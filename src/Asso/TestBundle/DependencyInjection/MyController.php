<?php

namespace Asso\TestBundle\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
	public function render($view, array $parameters = array(), Response $response = null)
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
}