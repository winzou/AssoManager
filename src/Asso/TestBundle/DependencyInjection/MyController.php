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
		return $this->render ( $templateName.'.'.$this->get('request')->getRequestFormat().'.twig' , $vars );
	}
}