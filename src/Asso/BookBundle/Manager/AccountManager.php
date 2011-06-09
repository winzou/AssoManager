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
use Asso\BookBundle\Entity\Account;

/**
 * AccountManager
 * @author winzou
 */
class AccountManager extends AbstractManager
{
    /**
     * Create and return an Account
     * @return Account
     */
    public function createAccount()
    {
        return parent::create();
    }
    
    /**
     * Delete the given Account
     * @param Account $Account
     */
    public function deleteAccount(Account $account)
    {
        return parent::delete($account);
    }
    
    public function deleteAccountsByWrap($wrap)
    {
        $wraps = (int) $wrap > 0 ? (array) $wrap : $wrap;
        
        $qb = $this->em->createQueryBuilder();
        $qb ->delete($this->class, 'a')
            ->join('a.entries', 'e')
            ->where($qb->expr()->in('a.wrap', $wraps));
    
    return $qb->getQuery()->execute();
    }
    
    /**
     * Update the given Account
     * @param Account $account
     * @param bool $andFlush
     */
    public function updateAccount(Account $account, $andFlush = true)
    {
        if( is_object($account->getWrap()) AND ! $account->getWrap()->getId() )
        {
            throw new \Exception('Wrap has to be flushed before adding an account.');
        }
        
        return parent::update($account, $andFlush);
    }
    
    /**
     * Return a Account according to criteria
     * @param array $criteria
     * @return Account
     */
    public function findAccountBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Return a list of Account according to criteria
     * @param array $criteria
     * @return ArrayCollection
     */
    public function findAccountsBy(array $criteria = array())
    {
        return $this->repository->findBy($criteria);
    }
}