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


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Httpfoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Asso\BookBundle\Form\EntryType;
use Asso\BookBundle\Form\EntryHandler;
use Asso\BookBundle\Entity\Entry;


/**
 * BookController
 * @author Asso
 */
class BookController extends AbstractController
{
    /**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function deleteEntryAction($id)
    {
        /** @todo get this dynamic */
        $this->get('session')->set('user.asso.id', $this->getUser()->getAssos()->first()->getId());
        
        $em = $this->get('asso_book.entry_manager');
        $request = $this->get('request');
        
        // check existence and permission
        if( ! $entry = $em->getFullOne($id)
        OR $entry->getAccount()->getWrap()->getId() != $this->get('session')->get('user.asso.id') )
        {
            if( $request->getRequestFormat() == 'json' )
            {
                return new Response( json_encode(array('message' => 'You dont have access to this resource.')) );
            }
            
            throw new AccessDeniedException('Current user doesnt have access to this entry, or this entry doesnt exist');
        }

        // post request: we really want to do this action
        if( $request->getMethod() == 'POST' )
        {
            $em->deleteEntry($entry);
            
            // ajax request: just return the action state
            if( $request->getRequestFormat() == 'json')
            {
                return new Response( json_encode(array('code' => true)) );
            }
            
            // normal request: set a flash and redirect to entries list
            $this->get('session')->setFlash('asso_book_notice', 'flash.delete.entry');
            
            return $this->redirect( $this->generateUrl('asso_book_list_entries') );
        }
        
        if( $request->getRequestFormat() == 'json')
        {
            return new Response( json_encode(array('message' => 'You must use the POST method here.')) );
        }
        
        // get request: we only want the confirmation form
        return $this->render( 'AssoBookBundle:Book:deleteEntry.html.twig', array('entry' => $entry));
    }
    
    
    public function listEntriesAction()
    {
        return $this->render( 'AssoBookBundle:Book:listEntries.html.twig', array(
        	'entries' => $this->get('asso_book.service')->getEntries(2)
        ));
    }
    
    
    public function indexAction()
    {
        /*
        $entrys = $this->get->getRepository('Asso\AMBundle\Entity\User');
        $Assos = $this->em->getRepository('Asso\AMBundle\Entity\Asso');
        $accounts = $this->em->getRepository('Asso\BookBundle\Entity\Account');
        $entries = $this->em->getRepository('Asso\BookBundle\Entity\Entry');
        
        $entry = $entrys->find(1);
        */
        
        //$account = $this->get('asso_book.account_manager')->findAccountBy(array('id'=>1))->setWrap('moi');
        
        /*
        $entry = new Entity\Entry;
        $entry->setUser($entry);
        $entry->setAmount(99);
        $entry->setLabel('Second buy');
        */
        
        /*
        $account = new Entity\Account;
        $account->setName('Banque');
        $this->em->persist($account);
        */
        
        /*
        $account = $accounts->find(1);
        $entry->setAccount($account);
        
        $itemClass = new Entity\ItemClass;
        $itemClass->setNamespace(get_class($account));
        $this->em->persist($itemClass);
        
        $item = new Entity\Item;
        $item->setClass($itemClass);
        $item->setObjectId($account->getId());
        $this->em->persist($item);
        
        $entry->setItem($item);
        
        $this->em->persist($entry);
        $this->em->flush();
        */
        
        /*
        foreach($this->get('asso_book.entry_manager')->findEntriesByAccount(array(1,2), false) as $entry)
        {
            var_dump($entry->getUser()->getUsername());
        }
        */
        
        $wbs = $this->get('asso_book.service');
        
		return $this->myRender('AssoBookBundle:Book:showEntries', array('entries' => $wbs->getEntries(2)));
	}
	
	public function newAction()
	{
        $form = $this->get('asso_book.forms.entry');
        $formHandler = $this->get('asso_book.forms.entry_handler');

        if( $formHandler->process() )
        {
            $entry = $form->getData();
            
            $this->get('session')->setFlash('notice', 'Your changes were saved!');

            return $this->redirect(
                $this->get('router')->generate('asso_book_show', array('id' => $entry->getId()))
            );
        }
        
        return $this->myRender('AssoBookBundle:Book:new', array(
            'form' => $form->createView()
        ));
	}
	
	public function showAction($id)
	{
	    try {
	        $entry = $this->get('asso_book.entry_manager')->getFullOne($id, false);
	    }
	    catch( NoResultException $e ) {
	        throw new NotFoundHttpException('Entry[id='.$id.'] not found', $e->getPrevious());
	    }
	    $this->get('session')->set('moi', 'par ici !');
        return $this->myRender('AssoBookBundle:Book:show', array(
	        'entry' => $entry
	    ));
	}
	
	
	public function newAccountAction()
	{
	    $form = $this->get('asso_book.forms.account');
	    $formHandler = $this->get('asso_book.forms.account_handler');
	    
	    if( $formHandler->process() )
	    {
	        return $this->redirect(
	            $this->get('router')->generate('asso_book_showAccount', array('id' => $form->getData()->getId()))
	        );
	    }
	    
	    return $this->myRender('AssoBookBundle:Book:newAccount', array(
	        'form' => $form->createView()
	    ));
	}
	
    public function showAccountAction($id)
	{
	    try {
	        $account = $this->get('asso_book.account_manager')->getFullOne($id, false);
	    }
	    catch( NoResultException $e ) {
	        throw new NotFoundHttpException('Account[id='.$id.'] not found', $e->getPrevious());
	    }
	    
        return $this->myRender('AssoBookBundle:Book:showAccount', array(
	        'account' => $account
	    ));
	}
}
