<?php

namespace Asso\MaterialBundle;

use Asso\MaterialBundle\Manager\EntryManager;
use Asso\MaterialBundle\Manager\AccountManager;

/**
 * Base Material service
 * @author winzou
 */
class MaterialService
{
    /** @var Asso\MaterialBundle\Manager\EntryManager */
    protected $em;

    /** @var Asso\MaterialBundle\Manager\AccountManager */
    protected $am;


    /**
     * Constructor.
     *
     * @param EntryManager $em
     * @param AccountManager $am
     */
    public function __construct($em, $am)
    {
        $this->em = $em;
        $this->am = $am;
    }

    public function getEntries($wrap)
    {
        return $this->em->getByWrap($wrap);
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

        return $this->em->update($entry);
    }

    public function updateAccount(Account $account)
    {
        return $this->am->update($account);
    }

    public function deleteEntry(Entry $entry)
    {
        return $this->em->delete($entry);
    }

    public function deleteAccount(Account $account)
    {
        return $this->am->delete($account);
    }

    public function deleteAccountsByWrap($wrap)
    {
        return $this->am->deleteByWrap($wrap);
    }
}