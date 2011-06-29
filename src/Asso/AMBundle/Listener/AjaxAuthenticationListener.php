<?php

namespace Asso\AMBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * @author Illya Klymov (xanf on GitHub)
 */
class AjaxAuthenticationListener
{
    /**
     * Handles security related exceptions.
     *
     * @param GetResponseForExceptionEvent $event An GetResponseForExceptionEvent instance
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $request = $event->getRequest();
        
        if( $request->isXmlHttpRequest() )
        {
            if( $exception instanceof AuthenticationException || $exception instanceof AccessDeniedException )
            {
                $response = array(
                    'message' => 'Ajax Authentication: '.$exception->getMessage(),
                    'type'    => 'error'
                );
                
                $event->setResponse( new Response(json_encode($response), 403) );
            }
        }
    }
}