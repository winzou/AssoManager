<?php

namespace Asso\AMBundle\Controller;

use Asso\AMBundle\DependencyInjection\MyController;
use Asso\AMBundle\Entity\Asso;
use Asso\AMBundle\Entity\User;

use Symfony\Component\Httpfoundation\Response;

class DashboardController extends MyController
{
    public function indexAction()
    {
        /*
        $asso = new Asso;
        $asso->setName('Trefle à 4L');
        
        $winzou = $this->em->getRepository('Asso\AMBundle\Entity\User')->find(1);
        $asso->addUser($winzou);
        
        $this->em->persist($asso);
        $this->em->persist($winzou);
        $this->em->flush();
        */
        
        /*
        $trefle = $this->em->getRepository('Asso\AMBundle\Entity\Asso')->find(2);
        foreach($trefle->getUsers() as $user)
        {
            echo $user->getUsername();
        }
        
        $winzou = $this->em->getRepository('Asso\AMBundle\Entity\User')->find(1);
        foreach($winzou->getAssos() as $asso)
        {
            echo $asso->getName();
        }
        */
        
        return $this->myRender('AssoAMBundle:Dashboard:index');
    }
}