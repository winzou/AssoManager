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
     * Return a list of entries belonging to the given critaeria
     * @param string $name The name of the constraint
     * @param mixed $value
     * @param bool $array Retrieve a read-only array instead of an ArrayCollection
     * @return array|ArrayCollection
     */
    private function getBy($name, $value, $array = true)
    {
        $qb = $this->createQueryBuilder('e');

        $qb = $this->addAssociations($qb);

        $qb ->where($name.' = :param')
                ->setParameter('param', $value)
            ->orderBy('e.date', 'desc');

        return $qb->getQuery()->getResult( $array ? Query::HYDRATE_ARRAY : Query::HYDRATE_OBJECT );
    }

    public function getByWrap($wrap, $array = true)
    {
        return $this->getBy('account.wrap', $wrap, $array);
    }

    public function getByAccount(Account $account, $array = true)
    {
        return $this->getBy('account', $account, $array);
    }

    public function deleteByIds($ids, $asso_id)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb ->delete($this->_entityName, 'e')
            ->where($qb->expr()->in('e.id', $ids))
            ->andWhere('e.account IN(SELECT a.id FROM Asso\BookBundle\Entity\Account AS a WHERE a.wrap = :asso_id)')
                ->setParameter('asso_id', $asso_id);

        return $qb->getQuery()->execute();
    }
}