<?php

namespace Asso\TestBundle\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Asso\TestBundle\DependencyInjection\MyController;
use Asso\TestBundle\Entity\User;
use Asso\TestBundle\Entity\Doc;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Symfony\Component\Httpfoundation\Response;

class DefaultController extends MyController
{
    public function createAction()
    {
    	$doc = new Doc();
    	$doc->setName('Greg');
    	
    	$em = $this->get('doctrine.orm.entity_manager');
    	$em->persist($doc);
    	$em->flush();
    	
    	
    	// creating the ACL
        $aclProvider = $this->container->get('security.acl.provider');
        $acl = $aclProvider->createAcl(ObjectIdentity::fromDomainObject($doc));

        // retrieving the security identity of the currently logged-in user
        $securityContext = $this->container->get('security.context');
        $securityIdentity = UserSecurityIdentity::fromAccount($securityContext->getToken()->getUser());

        // grant owner access
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_EDIT);
        $aclProvider->updateAcl($acl);
    	
    	return $this->render('AssoTestBundle:Default:create.html.twig', array('name' => $doc->getName()));
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
    }
}
