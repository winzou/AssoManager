<?php

namespace Asso\TestBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\RouterInterface;

/**
 * Change the RequestFormat 1/ if the request is an AJAX one and 2/ if the htmlRaw requirement is set in the matching route
 * @author winzou
 */
class RawFormatListener
{
	private $router;
	
	public function __construct(RouterInterface $router)
	{
		$this->router = $router;
	}
	
	public function onCoreController(FilterControllerEvent $event)
	{
		// AJAX request ?
		//if( $event->getRequest()->headers->has('P-AJAX') AND $event->getRequest()->headers->get('P-AJAX') )
		if( $event->getRequest()->isXmlHttpRequest() or true)
		{
			// htmlRaw in the route requirements ?
			// @todo Is there any better way to retrieve current route requirements ?
			if( in_array ( 'htmlRaw' , explode('|', $this->router->getRouteCollection()->get($event->getRequest()->attributes->get('_route'))->getRequirement('_format')) ) )
			{
				$event->getRequest()->setRequestFormat('htmlRaw');
			}
		}
	}
}