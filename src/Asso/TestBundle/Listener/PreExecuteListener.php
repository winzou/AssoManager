<?php

namespace Asso\TestBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class PreExecuteListener
{
	public function onCoreController(FilterControllerEvent $event)
	{
		if( $event->getRequestType() === HttpKernelInterface::MASTER_REQUEST )
		{
			$controller = $event->getController();
			
			if( isset ( $controller[0] ) AND method_exists ( $controller[0] , 'preExecute' ) )
			{
				$controller[0]->preExecute();
			}
		}
	}
}