<?php

namespace Asso\MaterialBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Asso\MaterialBundle\Entity\Material;

class LoadMaterialsData implements FixtureInterface
{
    public function load($manager)
    {
		for($i=0;$i<20;$i++) {
			$Material = new Material;
			$Material->setName('Un materiel no. '.$i);
			$manager->persist($Material);
		}

		$manager->flush();
    }
}