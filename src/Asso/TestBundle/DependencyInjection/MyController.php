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
	protected function myRender ( $templateName, array $vars = array() )
	{
		// Defining the Response format
		// header P-AJAX overrides
		if( $this->get('request')->headers->has('P-AJAX') AND $this->get('request')->headers->get('P-AJAX') )
		{
			$this->get('request')->setRequestFormat('htmlraw');
		}
		
		return $this->render ( $templateName.'.'.$this->get('request')->getRequestFormat().'.twig' , $vars );
	}
}