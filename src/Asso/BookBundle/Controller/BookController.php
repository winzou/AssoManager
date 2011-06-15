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
        $em = $this->get('asso_book.entry_manager');
        $request = $this->get('request');
        
        // check existence and permission
        if( ! $entry = $em->getFullOne($id)
        OR $entry->getAccount()->getWrap()->getId() != $this->get('asso.am.asso_selector')->getAssoId() )
        {
            throw new AccessDeniedException('User doesnt have access to this entry, or this entry doesnt exist');
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
            $this->get('session')->setFlash('asso_book_notice', 'flash.entry.delete');
            
            return $this->redirect( $this->generateUrl('asso_book_list_entries') );
        }
        
        if( $request->getRequestFormat() == 'json')
        {
            throw new MethodNotAllowedHttpException(array('POST'), 'You must use the POST method here.');
        }
        
        // get request: we only want the confirmation form
        return $this->render( 'AssoBookBundle:Book:deleteEntry.html.twig', array(
        	'entry' => $entry
        ));
    }
    
    /**
     * @Secure(roles="ROLE_TREASURER")
     */
    public function listEntriesAction()
    {
        $entries = $this->get('asso_book.service')->getEntries( $this->get('asso.am.asso_selector')->getAssoId() );
        
        if( $this->get('request')->getRequestFormat() == 'json' )
        {
            /** @todo Have to find a way to clean user attributes (passwd, etc) before dumping in json */
            //return new Response( json_encode($entries) );
            throw new NotFoundHttpException('You must not request the json format, try with html.');
        }
        
        return $this->render( 'AssoBookBundle:Book:listEntries.html.twig', array(
        	'entries' => $entries
        ));
    }
    
    /**
     * @Secure(roles="ROLE_TREASURER")
     */
	public function newAction()
	{
        $form = $this->get('asso_book.forms.entry');
        $formHandler = $this->get('asso_book.forms.entry_handler');

        if( $formHandler->process() )
        {
            $this->get('session')->setFlash('asso_book_notice', 'flash.entry.new');

            return $this->redirect(
                $this->get('router')->generate('asso_book_list_entries')
            );
        }
        
        return $this->render('AssoBookBundle:Book:new', array(
            'form' => $form->createView()
        ));
	}
	
	/**
     * @Secure(roles="ROLE_TREASURER")
     */
	public function newAccountAction()
	{
	    $form = $this->get('asso_book.forms.account');
	    $formHandler = $this->get('asso_book.forms.account_handler');
	    
	    if( $formHandler->process() )
	    {
	        $this->get('session')->setFlash('asso_book_notice', 'flash.account.new');
	        
	        return $this->redirect(
	            $this->get('router')->generate('asso_book_showAccount', array('id' => $form->getData()->getId()))
	        );
	    }
	    
	    return $this->render('AssoBookBundle:Book:newAccount', array(
	        'form' => $form->createView()
	    ));
	}
	
    
	
	public function asso_needAssoSelected()
	{
	    return true;
	}
}
