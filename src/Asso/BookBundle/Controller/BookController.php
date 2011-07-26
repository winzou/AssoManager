<?php

/*
 * This file is part of AssoBookBundle.
 *
 * AssoBookBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AssoBookBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asso\BookBundle\Controller;

use Asso\AbstractBundle\Controller\AbstractController;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Httpfoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Asso\BookBundle\Form\EntryType;
use Asso\BookBundle\Form\AccountType;
use Asso\BookBundle\Entity\Entry;
use Asso\BookBundle\Entity\Account;


class BookController extends AbstractController
{
    /**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function delete_entryAction($id)
    {
        $em = $this->get('asso_book.entry_manager');
        $request = $this->get('request');

        // check existence and permission
        if( ! $entry = $em->getFullOne($id)
        OR $entry->getAccount()->getWrap()->getId() != $this->getAssoId() )
        {
            throw new AccessDeniedException('User doesnt have access to this entry, or this entry doesnt exist');
        }

        // post request: we really want to do this action
        if( $request->getMethod() == 'POST' )
        {
            $em->delete($entry);

            // ajax request: just return the action state
            if( $request->getRequestFormat() == 'json')
            {
                return new Response( json_encode(array('code' => true)) );
            }

            // normal request: set a flash and redirect to entries list
            $this->get('session')->setFlash('asso_book_notice', 'book.flash.entry.delete');

            return $this->redirect( $this->generateUrl('asso_book_list_entries') );
        }

        if( $request->getRequestFormat() == 'json')
        {
            throw new MethodNotAllowedHttpException(array('POST'), 'You must use the POST method here.');
        }

        // get request: we only want the confirmation form
        return $this->render( 'AssoBookBundle:Book:delete_entry.html.twig', array(
            'entry' => $entry
        ));
    }

    /**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function list_entriesAction()
    {
        $assoId = $this->getAssoId();

        $entries     = $this->get('asso_book.service')->getEntries( $assoId );
        $form        = $this->createForm( new EntryType($assoId) , $this->get('asso_book.entry_manager')->create() );
        $formAccount = $this->createForm( new AccountType , $this->get('asso_book.account_manager')->create() );

        if( $this->getRequest()->getRequestFormat() == 'json' )
        {
            /** @todo Have to find a way to clean user attributes (passwd, etc) before dumping in json */
            //return new Response( json_encode($entries) );
            throw new NotFoundHttpException('You must not request the json format, try with html.');
        }

        return $this->render( 'AssoBookBundle:Book:list_entries.html.twig', array(
            'entries'     => $entries,
            'form'        => $form->createView(),
            'formAccount' => $formAccount->createView()
        ));
    }

    /**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function actionsAction()
    {
        $request = $this->get('request');

        // in the case where new is defined, we actually want to add a new entry, let's forward to the good action
        if( $request->request->has('new') )
        {
            return $this->forward('AssoBookBundle:Book:new_entry');
        }

        if( ! $request->request->has('entry_chk') )
        {
            throw new \Exception('book.flash.request.bad');
        }

        $assoId = $this->getAssoId();

        $this->get('asso_book.service')->deleteEntries($request->request->get('entry_chk'), $assoId);

        $this->get('session')->setFlash('asso_book_notice', 'book.flash.actions.delete');

        return $this->redirect( $this->generateUrl('asso_book_list_entries') );
    }

    /**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function new_entryAction()
    {
        $assoId = $this->getAssoId();

        /** @var Asso\BookBundle\Form\EntryHandler */
        $form        = $this->createForm( new EntryType($assoId) , $this->get('asso_book.entry_manager')->create() );
        $formHandler = $this->get('asso_book.forms.entry');

        if( $this->getRequest()->isXmlHttpRequest() )
        {
            if( $formHandler->process($form) )
            {
                return new Response( json_encode(array(
                    'code'   => true,
                    'notice' => $this->get('translator')->trans('book.flash.entry.new', array(), 'AssoBookBundle'),
                    'tr'     => $this->renderView('AssoBookBundle:Book:entry', array('entry' => $form->getData()))
                )) );
            }

            return new Response( json_encode(array(
                'code' => false,
                'error' => 'Erreur' /** @todo How to retrieve all error messages here? */
            )) );
        }

        if( $formHandler->process($form) )
        {
            $this->get('session')->setFlash('asso_book_notice', 'book.flash.entry.new');

            return $this->redirect(
                $this->get('router')->generate('asso_book_list_entries')
            );
        }

        return $this->render('AssoBookBundle:Book:new_entry', array(
            'form' => $form->createView()
        ));
    }
    
	/**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function edit_entryAction( Entry $entry )
    {
        $assoId = $this->getAssoId();
        
        if( $entry->getAccount()->getWrap()->getId() != $assoId )
        {
            throw new AccessDeniedException('User doesnt have access to this entry, or this entry doesnt exist.');
        }

        /** @var Asso\BookBundle\Form\EntryHandler */
        $form        = $this->createForm( new EntryType($assoId) , $entry );
        $formHandler = $this->get('asso_book.forms.entry');

        if( $formHandler->process($form) )
        {
            $this->get('session')->setFlash('asso_book_notice', 'book.flash.entry.edit');

            return $this->redirect(
                $this->get('router')->generate('asso_book_list_entries')
            );
        }

        return $this->render('AssoBookBundle:Book:edit_entry', array(
            'form'  => $form->createView(),
            'entry' => $entry
        ));
    }

    /**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function new_accountAction()
    {
        $account = $this->get('asso_book.account_manager')->create();
        $account->setWrap($this->getAsso());
        
        $form        = $this->createForm( new AccountType , $account );
        $formHandler = $this->get('asso_book.forms.account_handler');

        if( $formHandler->process($form) )
        {
            $this->get('session')->setFlash('asso_book_notice', 'book.flash.account.new');

            return $this->redirect(
                $this->get('router')->generate('asso_book_list_entries', array('id' => $form->getData()->getId()))
            );
        }

        return $this->render('AssoBookBundle:Book:new_account', array(
            'form' => $form->createView()
        ));
    }
    
	/**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function delete_accountAction( Account $account )
    {
        $am = $this->get('asso_book.account_manager');
        $request = $this->get('request');

        // check existence and permission
        if( $account->getWrap()->getId() != $this->getAssoId() )
        {
            throw new AccessDeniedException('User doesnt have access to this account, or this account doesnt exist.');
        }

        // post request: we really want to do this action
        if( $request->getMethod() == 'POST' )
        {
            $am->delete($account);

            // normal request: set a flash and redirect to entries list
            $this->get('session')->setFlash('asso_book_notice', 'book.flash.entry.delete');

            return $this->redirect( $this->generateUrl('asso_book_list_entries') );
        }

        if( $request->getRequestFormat() == 'json')
        {
            throw new MethodNotAllowedHttpException(array('POST'), 'You must use the POST method here.');
        }

        // get request: we only want the confirmation form
        return $this->render( 'AssoBookBundle:Book:delete_entry.html.twig', array(
            'entry' => $entry
        ));
    }



    public function asso_needAssoSelected($action)
    {
        return true;
    }
}
