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

use Asso\BookBundle\Entity\EntryRepository;
use Asso\BookBundle\Entity\AccountRepository;

use Asso\BookBundle\Entity\Entry;
use Asso\BookBundle\Entity\Account;

/**
 * Base book service
 * @author winzou
 */
class BookService
{
    /** @var Asso\BookBundle\Entity\EntryRepository */
    protected $em;

    /** @var Asso\BookBundle\Entity\AccountRepository */
    protected $am;


    /**
     * Constructor.
     *
     * @param EntryRepository $em
     * @param AccountRepository $am
     */
    public function __construct(EntryRepository $em, AccountRepository $am)
    {
        $this->em = $em;
        $this->am = $am;
    }

    public function getEntry($id)
    {
        return $this->em->getFullOne($id);
    }

    public function getAccount($id)
    {
        return $this->am->find($id);
    }

    public function getEntries(Account $account)
    {
        return $this->em->getByAccount($account);
    }

    public function getAccounts($wrap)
    {
        return $this->am->findBy(array('wrap' => $wrap));
    }

    public function createEntry()
    {
        return $this->em->create();
    }

    public function createAccount()
    {
        return $this->am->create();
    }

    public function updateEntry(Entry $entry)
    {
        if( ! $entry->getAccount()->getId() )
        {
            $this->am->update($entry->getAccount(), false);
        }

        $this->em->update($entry);
    }

    public function updateAccount(Account $account)
    {
        $this->am->update($account);
    }

    public function deleteEntry(Entry $entry)
    {
        $this->em->delete($entry);
    }

    public function deleteEntries($ids, $asso_id)
    {
        $this->em->deleteByIds($ids, $asso_id);
    }

    public function deleteAccount(Account $account)
    {
        $this->em->deleteByAccount($account, false);
        $this->am->delete($account);
    }

    public function deleteAccountsByWrap($wrap)
    {
        $this->am->deleteByWrap($wrap);
    }

    public function countEntries(Account $account)
    {
        return $this->em->countByAccount($account);
    }

    public function filterEntries(array $list_ids, $asso_id)
    {
        return $this->em->filter($list_ids, $asso_id);
    }
}