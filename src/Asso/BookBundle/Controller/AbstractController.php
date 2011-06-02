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