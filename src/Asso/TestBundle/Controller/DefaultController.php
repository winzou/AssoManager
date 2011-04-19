<?php

namespace Asso\TestBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Asso\TestBundle\DependencyInjection\MyController;
use Asso\TestBundle\Entity\User;

class DefaultController extends MyController
{
    public function createAction()
    {
    	$user = new User();
    	$user->setName('Jack');
    	
    	$em = $this->get('doctrine.orm.entity_manager');
    	
    	$em->persist($user);
    	$em->flush();
    	
        return $this->render('AssoTestBundle:Default:create.html.twig', array('name' => $user->getUsername()));
    }
    
    public function listAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	
    	$dql = 'SELECT u FROM Asso\TestBundle\Entity\User u';
    	$users = $em->createQuery($dql)->getResult();
    	
    	return $this->myRender ( 'AssoTestBundle:Default:list' , array('users' => $users) );
    }
}
