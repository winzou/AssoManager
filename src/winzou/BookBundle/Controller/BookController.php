<?php

namespace winzou\BookBundle\Controller;

/** @todo Beautiful dependency */
use Asso\AMBundle\DependencyInjection\MyController;

use Symfony\Component\Httpfoundation\Response;

use winzou\BookBundle\Entity;

class BookController extends MyController
{
    public function indexAction()
    {
        $users = $this->em->getRepository('Asso\AMBundle\Entity\User');
        $winzous = $this->em->getRepository('Asso\AMBundle\Entity\Asso');
        $accounts = $this->em->getRepository('winzou\BookBundle\Entity\Account');
        $entries = $this->em->getRepository('winzou\BookBundle\Entity\Entry');
        
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
        
        /*
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
        */
        
        $entry = $entries->find(2);
        
        
		return $this->myRender('winzouBookBundle:Book:index');
	}
}