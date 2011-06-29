<?php

namespace Asso\AMBundle\Listener;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Router;

use Asso\AMBundle\Entity\Asso;
use Asso\UserBundle\Entity\User;


/**
 * Asso retrieval service
 * @author winzou
 */
class AssoSelectorListener
{
    /** @var Session */
    protected $session;
    
    /** @var SecurityContext */
    protected $security;
    
    /** @var Router */
    protected $router;
    
    /** var Asso */
    protected $Asso;
    
    /** var bool */
    protected $willRedirect;

    /**
     * Constructor.
     *
     * @param Session $session
     * @param SecurityContext $security
     */
    public function __construct(Session $session, SecurityContext $security, Router $router)
    {
        $this->session  = $session;
        $this->security = $security;
        $this->router   = $router;
    }
    
    /**
     * Retrieve the Asso id on login event
     *
     * @param InteractiveLoginEvent $event
     * @throws AccessDeniedException
     * @throws \LogicException
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	{
	    $user = $event->getAuthenticationToken()->getUser();

        if( count($user->getAssos()) > 1 )
	    {
	        /** @todo Handle multiple assos */
	        throw new \LogicException('Case not handled yet');
	    }
	    
	    $this->Asso = $user->getAssos()->first();
	    $this->_setAssoId( $this->Asso->getId() );
	}
	
	/**
	 * Check if the Asso id is available on each request
	 *
	 * @param FilterControllerEvent $event
	 */
	public function onKernelController(FilterControllerEvent $event)
	{
		if( $event->getRequestType() === HttpKernelInterface::MASTER_REQUEST )
		{
		    // if there is no Asso id
		    if( ! $this->_hasAssoId() )
		    {
		        $controller = $event->getController();
		        
		        if( is_array($controller) AND method_exists ( $controller[0] , 'asso_needAssoSelected' ) )
			    {
			        // and if we need it
			        if( $controller[0]->asso_needAssoSelected($controller[1]) )
			        {
			            // then we redirect to the selection page
			            $this->willRedirect = true;
			            $event->setController(null);
			        }
			    }
	        }
		}
	}
	
	public function onKernelResponse(FilterResponseEvent $event)
	{
	    if( $this->willRedirect )
	    {
	        $event->setResponse( new RedirectResponse($this->router->generate('asso_am_asso_select')) );
	    }
	}
    
	/**
	 * Return the current Asso
	 *
	 * @throws \LogicException
	 * @throws \Exception
	 *
	 * @return Asso
	 */
    public function getAsso()
    {
        if( ! $this->Asso )
        {
            if( $this->_mustHasAssoId() )
            {
                // Retrieve the Asso from the User, without any new request
                if( ! $user = $this->_getUser() )
                {
                    throw new \LogicException('User not available in AssoSelector::getAsso. Maybe you called this method out the backend scope covered by a user firewall?');
                }
            
                // ArrayCollections are not indexed by the primary key, we have to iterate over it
                foreach( $user->getAssos() as $asso )
                {
                    if( $asso->getId() == $this->_getAssoId() )
                    {
                        return $this->Asso = $asso;
                    }
                }
                
                if( ! $this->Asso )
                {
                    throw new \Exception('Unable to load Asso[id='.$this->_getAssoId().'] from User[id='.$user->getId().']');
                }
            }
        }
        
        return $this->Asso;
    }
    
    /**
     * Return the current Asso id
     * @throws \LogicException
     * @return int
     */
    public function getAssoId()
    {
        if( $this->_mustHasAssoId() )
        {
            return $this->_getAssoId();
        }
    }
    
    protected function _getAssoId()
    {
        return $this->session->get('asso.am.asso_id');
    }
    
    /**
     * Ensure that an Asso is defined for the session
     * @todo Handle the case where it's not
     * @throws \LogicException
     */
    protected function _mustHasAssoId()
    {
        if( ! $this->_hasAssoId() )
        {
            throw new \LogicException('Asso id not defined ??');
        }
        
        return true;
    }
    
    protected function _hasAssoId()
    {
        return $this->session->has('asso.am.asso_id');
    }
    
    protected function _setAssoId($asso_id)
    {
        $this->session->set('asso.am.asso_id', $asso_id);
    }
    
    protected function _getUser()
    {
        return $this->security->getToken()->getUser();
    }
    
    public function __toString()
    {
        return '[asso_listener] AssoSelectorListener';
    }
    
    
}