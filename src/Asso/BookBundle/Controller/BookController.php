<?php

namespace Asso\BookBundle\Controller;

use Asso\AMBundle\DependencyInjection\MyController;

use Symfony\Component\Httpfoundation\Response;

use Asso\BookBundle\Entity;

class BookController extends MyController
{
    public function indexAction()
    {
        $users = $this->em->getRepository('Asso\AMBundle\Entity\User');
        $assos = $this->em->getRepository('Asso\AMBundle\Entity\Asso');
        $accounts = $this->em->getRepository('Asso\BookBundle\Entity\Account');
        $classes = $this->em->getRepository('Asso\BookBundle\Entity\ItemClass');
        $entries = $this->em->getRepository('Asso\BookBundle\Entity\Entry');
        $items = $this->em->getRepository('Asso\BookBundle\Entity\Item');
        
        $user = $users->find(1);
        
        $entry = new Entity\Entry;
        $entry->setUser($user);
        $entry->setAmount(99);
        $entry->setLabel('Second buy');
        
        /*
        $account = new Entity\Account;
        $account->setName('Banque');
        $this->em->persist($account);
        */
        $account = $accounts->find(1);
        $entry->setAccount($account);
        
        $itemClass = new Entity\ItemClass;
        $itemClass->setNamespace(get_class($account));
        $this->em->persist($itemClass);
        
        $item = new Entity\Item;
        $item->setClass($itemClass);
        $item->setObjectId($account->getId());
        $this->em->persist($item);
        
        $entry->setItem($item);
        
        $this->em->persist($entry);
        $this->em->flush();
        
        
		return $this->myRender('AssoBookBundle:Book:index');
	}
}