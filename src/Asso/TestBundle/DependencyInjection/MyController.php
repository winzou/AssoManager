<?php

namespace Asso\TestBundle\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Symfony\Component\Security\Core\User\UserInterface;


class MyController extends Controller
{
	/**
	 * Provide a shortcut to handle many formats
	 *
	 * @param string $templateName
	 * @param array $vars
	 *
	 * @return Response
	 */
	public function myRender($view, array $parameters = array(), Response $response = null)
	{
	    if( strpos($view, '.') === false )
	    {
	        $request = $this->get('request');
	        
	        if( $request->isXmlHttpRequest() AND $request->getRequestFormat() === 'html' )
            {
                $view .= 'Base';
            }
            
            $view .= '.'.$request->getRequestFormat().'.twig';
	    }
	    
		return parent::render ( $view , $parameters , $response );
	}
	
	public function addACL($object, $mask)
	{
	    if( ! in_array($mask, array('view', 'edit', 'delete', 'undelete', 'operator', 'owner')) )
	    {
	        throw new \Exception('"'.$mask.'" must be in (view, edit, delete, undelete, operator, owner');
	    }
	    
	    switch($mask)
	    {
	        case "view":     $mask = MaskBuilder::MASK_VIEW;     break;
	        case "edit":     $mask = MaskBuilder::MASK_EDIT;     break;
	        case "delete":   $mask = MaskBuilder::MASK_DELETE;   break;
	        case "undelete": $mask = MaskBuilder::MASK_UNDELETE; break;
	        case "operator": $mask = MaskBuilder::MASK_OPERATOR; break;
	        case "owner":    $mask = MaskBuilder::MASK_OWNER;    break;
	    }
	    
	    $securityContext = $this->container->get('security.context');
	    
	    if( ( $user = $securityContext->getToken()->getUser() ) instanceof UserInterface )
	    {
    	    // creating the ACL
            $aclProvider = $this->container->get('security.acl.provider');
            $acl = $aclProvider->createAcl(ObjectIdentity::fromDomainObject($object));
    
            // retrieving the security identity of the currently logged-in user
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
    
            // grant owner access
            $acl->insertObjectAce($securityIdentity, $mask);
            $aclProvider->updateAcl($acl);
	    }
	}
}