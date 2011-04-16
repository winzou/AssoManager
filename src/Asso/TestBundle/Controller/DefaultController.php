<?php

namespace Asso\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AssoTestBundle:Default:index.html.twig');
    }
}
