<?php

namespace Asso\AbstractBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Httpfoundation\Response;


/**
 * AbstractController
 * @author winzou
 */
abstract class AbstractController extends Controller
{
	/**
	 * Provide a shortcut to handle request format and engine guessing
	 *
	 * @param string $view
	 * @param array $parameters
	 * @param Response $response
	 *
	 * @return Response
	 */
	protected function myRender($view, array $parameters = array(), Response $response = null)
	{
	    // if no "." found : we want to use the shorcut
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
	
	
	/**
     * Get a user from the security context
     *
     * @throws AccessDeniedException if no user is authenticated
     * @return User
     */
    protected function getUser()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if( ! is_object($user) || ! $user instanceof UserInterface )
        {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $user;
    }
}