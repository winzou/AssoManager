<?php

namespace Asso\BookBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Asso\BookBundle\Entity\Entry;
use Asso\BookBundle\Entity\Account;

class LoadEntriesData implements FixtureInterface
{
    public function load($manager)
    {
		$accounts[0] = new Account;
		$accounts[0]->setName('Compte bancaire');
		$accounts[0]->setWrap($manager->getRepository('Asso\\AMBundle\\Entity\\Asso')->find(1));
		$manager->persist($accounts[0]);
		
		$accounts[1] = new Account;
		$accounts[1]->setName('Caisse');
		$accounts[1]->setWrap($manager->getRepository('Asso\\AMBundle\\Entity\\Asso')->find(1));
		$manager->persist($accounts[1]);
		
		for($i=0;$i<20;$i++) {
			$entry = new Entry;
			$entry->setAccount($accounts[mt_rand(0,1)]);
			$entry->setLabel('Une depense/rentree no. '.$i);
			$entry->setAmount(mt_rand(-200,200));
			$manager->persist($entry);
		}
		
		$manager->flush();
    }
}