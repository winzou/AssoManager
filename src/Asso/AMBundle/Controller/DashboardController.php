<?php

namespace Asso\AMBundle\Controller;

use Asso\AbstractBundle\Controller\AbstractController;

use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\Httpfoundation\Response;

class DashboardController extends AbstractController
{
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
        return $this->render('AssoAMBundle:Dashboard:index');
    }
    
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function AssoSelectAction()
    {
        return $this->render('AssoAMBundle:Dashboard:AssoSelect');
    }
    
    
    public function asso_needAssoSelected($action)
    {
        return ( $action != 'AssoSelectAction' );
    }
}