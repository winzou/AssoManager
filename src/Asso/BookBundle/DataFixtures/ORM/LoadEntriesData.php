<?php

namespace Asso\BookBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Asso\BookBundle\Entity\Entry;
use Asso\BookBundle\Entity\Account;
use Asso\BookBundle\Entity\Category;

class LoadEntriesData implements FixtureInterface
{
    public function load($manager)
    {
        $asso = $manager->getRepository('Asso\\AMBundle\\Entity\\Asso')->find(1);

        foreach(array('Compte Bancaire', 'Caisse', 'Epargne') as $i => $account)
        {
    		$accounts[$i] = new Account;
    		$accounts[$i]->setName($account);
    		$accounts[$i]->setWrap($asso);
    		$manager->persist($accounts[$i]);
        }

        foreach(array('Cotisations', 'FBCF', 'Sorties', 'Materiel') as $i => $category)
        {
            $categories[$i] = new Category;
            $categories[$i]->setName($category);
            $categories[$i]->setWrap($asso);
            $manager->persist($categories[$i]);
        }

		for($i=0;$i<40;$i++) {
			$entry = new Entry;
			$entry->setAccount($accounts[mt_rand(0,2)]);
			$entry->setCategory($categories[mt_rand(0,3)]);
			$entry->setLabel('Une dépense/rentrée no. '.$i);
			$entry->setAmount(mt_rand(-900,900));
			$manager->persist($entry);
		}

		$manager->flush();
    }
}