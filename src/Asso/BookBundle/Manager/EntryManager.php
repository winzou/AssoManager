<?php

/*
 * This file is part of AssoBookBundle.
 *
 * AssoBookBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AssoBookBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asso\BookBundle\Manager;

use Asso\AbstractBundle\Manager\AbstractManager;
use Asso\BookBundle\Entity\Entry;

use Doctrine\ORM\Query;

/**
 * EntryManager
 * @author winzou
 */
class EntryManager extends AbstractManager
{
    /**
     * Create and return an Entry
     * @return Entry
     */
    public function createEntry()
    {
        return parent::create();
    }
    
    /**
     * Delete the given Entry
     * @param Entry $entry
     */
    public function deleteEntry(Entry $entry)
    {
        return parent::delete($entry);
    }
    
    /**
     * Update the given Entry
     * @param Entry $entry
     * @param bool $andFlush
     */
    public function updateEntry(Entry $entry, $andFlush = true)
    {
        return parent::update($entry, $andFlush);
    }
    
    /**
     * Return a list of entries belonging to the given wrap
     * @param array $wrap
     * @param bool $array Retrieve a read-only array instead of an ArrayCollection
     * @return array|ArrayCollection
     */
    private function getEntriesBy($name, $value, $array = true)
    {
        $qb = $this->repository->createQueryBuilder('e');
        
        $qb = $this->addAssociations($qb);
        
        $qb ->where($name.' = :param')
                ->setParameter('param', $value)
            ->orderBy('e.date', 'desc');
        
        return $qb->getQuery()->getResult( $array ? Query::HYDRATE_ARRAY : Query::HYDRATE_OBJECT );
    }
    
    public function getEntriesByWrap($wrap, $array = true)
    {
        return $this->getEntriesBy('account.wrap', $wrap, $array);
    }
    
    public function getEntriesByAccount(Account $account, $array = true)
    {
        return $this->getEntriesBy('account', $account, $array);
    }
    
    /**
     * Return a Entry according to criteria
     * @param array $criteria
     * @return Entry
     */
    public function findEntryBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Return a list of Entry according to criteria
     * @param array $criteria
     * @return ArrayCollection
     */
    public function findEntriesBy(array $criteria = array())
    {
        return $this->repository->findBy($criteria);
    }
}