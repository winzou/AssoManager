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
	public function myRender($view, array $parameters = array(), Response $response = null)
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
	 * Do this controller need AssoSelector listener look for an Asso?
	 * @return false
	 */
	public function asso_needAssoSelected()
	{
	    $this->get('logger')->debug('Using asso_needAssoSelected() from the AbstractController. "'.get_class($this).'" should define this method itself.');
	    
	    return false;
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
            throw new AccessDeniedException('User does not have access to this page.');
        }

        return $user;
    }
}