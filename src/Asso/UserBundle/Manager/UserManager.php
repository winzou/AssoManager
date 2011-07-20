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

namespace Asso\UserBundle\Manager;

use Doctrine\ORM\EntityRepository;

/**
 * UserManager
 * @author winzou
 */
class UserManager extends EntityRepository
{
    /**
     * Return a querybuilder for EntityChoiceList
     * @param integer $asso_id
     */
    public function getQueryChoicelist($asso_id)
    {
        $qb = $this->createQueryBuilder('u')
            ->join('u.assos', 'a')
            ->where('a.id = :asso_id')
                ->setParameter('asso_id', $asso_id);

        return $qb;
    }
}