<?php

namespace Asso\UserBundle\Controller;

use Asso\AbstractBundle\Controller\AbstractController;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Httpfoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Asso\BookBundle\Form\EntryType;
use Asso\BookBundle\Form\EntryHandler;
use Asso\BookBundle\Entity\Entry;


/**
 * UserController
 * @author Asso
 */
class UserController extends AbstractController
{
    public function showAction($username)
    {
        /** @todo Do a real showAction here */
        return new Response('ok lah');
    }
}