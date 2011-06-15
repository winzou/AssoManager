<?php

namespace Asso\AMBundle\Manager;

use Asso\AbstractBundle\Manager\AbstractManager;
use Asso\AMBundle\Entity\Asso;

use Doctrine\ORM\Query;

/**
 * AssoManager
 * @author winzou
 */
class AssoManager extends AbstractManager
{
    /**
     * Create and return an Asso
     * @return Asso
     */
    public function createAsso()
    {
        return parent::create();
    }
    
    /**
     * Delete the given Asso
     * @param Asso $Asso
     */
    public function deleteAsso(Asso $Asso)
    {
        return parent::delete($Asso);
    }
    
    /**
     * Update the given Asso
     * @param Asso $Asso
     * @param bool $andFlush
     */
    public function updateAsso(Asso $Asso, $andFlush = true)
    {
        return parent::update($Asso, $andFlush);
    }
    
    /**
     * Return a Asso according to criteria
     * @param array $criteria
     * @return Asso
     */
    public function findAssoBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Return a list of Asso according to criteria
     * @param array $criteria
     * @return ArrayCollection
     */
    public function findAssosBy(array $criteria = array())
    {
        return $this->repository->findBy($criteria);
    }
}