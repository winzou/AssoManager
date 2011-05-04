<?php

namespace Asso\AMBundle\Controller;

use Asso\AMBundle\DependencyInjection\MyController;

use Symfony\Component\Httpfoundation\Response;

class DashboardController extends MyController
{
    public function indexAction()
    {
        return $this->myRender('AssoAMBundle:Dashboard:index');
    }
}