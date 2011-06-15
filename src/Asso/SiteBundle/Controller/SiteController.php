<?php

namespace Asso\SiteBundle\Controller;

use Asso\AbstractBundle\Controller\AbstractController;

use Symfony\Component\Httpfoundation\Response;

class SiteController extends AbstractController
{
    public function indexAction()
    {
		return $this->render('AssoSiteBundle:Site:index');
	}
}