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

namespace Asso\BookBundle;

use Asso\BookBundle\Manager\EntryManager;
use Asso\BookBundle\Manager\AccountManager;

/**
 * Base book service
 * @author winzou
 */
class BookService
{
    /**
     * @var Asso\BookBundle\Manager\EntryManager
     */
    protected $em;
    
    /**
     * @var Asso\BookBundle\Manager\AccountManager
     */
    protected $am;
    
    
    /**
     * Constructor.
     *
     * @param EntryManager $em
     * @param AccountManager $am
     */
    public function __construct(EntryManager $em, AccountManager $am)
    {
        $this->em = $em;
        $this->am = $am;
    }
    
    public function getEntries($wrap)
    {
        return $this->em->getEntriesByWrap($wrap);
    }
    
    public function getAccounts($wrap)
    {
        return $this->am->findAccountsBy(array('wrap' => $wrap));
    }
    
    public function createEntry()
    {
        return $this->em->createEntry();
    }
    
    public function createAccount()
    {
        return $this->am->createAccount();
    }
    
    public function updateEntry(Entry $entry)
    {
        if( ! $entry->getAccount()->getId() )
        {
            $this->am->update($entry->getAccount(), false);
        }
        
        return $this->em->update($entry);
    }
    
    public function updateAccount(Account $account)
    {
        return $this->am->update($account);
    }
    
    public function deleteEntry(Entry $entry)
    {
        return $this->em->deleteEntry($entry);
    }
    
    public function deleteAccount(Account $account)
    {
        return $this->am->deleteAccount($account);
    }
    
    public function deleteByWrap($wrap)
    {
        return $this->am->deleteAccountsByWrap($wrap);
    }
}