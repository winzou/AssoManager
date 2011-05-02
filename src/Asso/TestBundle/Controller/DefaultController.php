<?php

namespace Asso\TestBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Asso\TestBundle\DependencyInjection\MyController;
use Asso\TestBundle\Entity\User;
use Asso\TestBundle\Entity\Doc;
use Asso\TestBundle\Form\DocType;

use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Symfony\Component\Httpfoundation\Response;

class DefaultController extends MyController
{
    public function createAction()
    {
        $form = $this->get('form.factory')->create(new DocType());
        
        if($this->request->getMethod() == 'POST')
        {
            $form->bindRequest($this->request);
    
            if($form->isValid())
            {
                $this->em->persist($form->getData());
            	$this->em->flush();
            	
            	// set ACL
            	$this->addACL($form->getData(), MaskBuilder::MASK_EDIT);
            	
                // perform some action, such as save the object to the database
                $this->get('session')->setFlash('msg', 'OK !');
                
                return $this->redirect($this->generateUrl('AssoTestView', array('id' => $form->getData()->getId())));
            }
        }
        
    	return $this->myRender('AssoTestBundle:Default:create', array(
    	    'form' => $form->createView()
    	));
    }
    
    public function listAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	
    	$dql = 'SELECT u FROM Asso\TestBundle\Entity\User u';
    	$users = $em->createQuery($dql)->getResult();
    	
    	return $this->myRender ( 'AssoTestBundle:Default:list' , array('users' => $users) );
    }
    
    /**
     * @extra:SecureParam(name="doc", permissions="EDIT")
     */
    public function viewAction( Doc $doc )
    {
    	return $this->myRender('AssoTestBundle:Default:view', array('name' => $doc->getName()));
    }
    
    public function preExecute()
    {
        // do something
    	$this->request = $this->get('request');
    	$this->em = $this->get('doctrine.orm.entity_manager');
    }
}
