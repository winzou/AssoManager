<?php

namespace Asso\SiteBundle\Controller;

use Asso\AMBundle\DependencyInjection\MyController;

use Symfony\Component\Httpfoundation\Response;

class SiteController extends MyController
{
    public function indexAction()
    {
		return $this->myRender('AssoSiteBundle:Site:index');
	}
}