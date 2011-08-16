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

namespace Asso\BookBundle\Entity;

use Asso\AbstractBundle\Manager\AbstractRepository;
use Asso\BookBundle\Entity\Category;

/**
 * CategoryManager
 * @author winzou
 */
class CategoryRepository extends AbstractRepository
{
    /**
     * Return a querybuilder for EntityChoiceList
     * @param integer $wrap_id
     */
    public function getQueryChoicelist($wrap_id)
    {
        return $this
            ->createQueryBuilder('c')
            ->where('c.wrap = :wrap')
                ->setParameter('wrap', $wrap_id);
    }
}