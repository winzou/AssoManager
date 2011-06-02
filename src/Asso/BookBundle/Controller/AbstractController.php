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
}