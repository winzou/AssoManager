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

namespace Asso\BookBundle\Form;

use Asso\AbstractBundle\Form\AbstractFormHandler;
use Asso\BookBundle\Manager\AccountManager;
use Asso\BookBundle\Entity\Account;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * AccountHandler
 * @author winzou
 */
class AccountHandler extends AbstractFormHandler
{
    /** @var Asso\BookBundle\Manager\AccountManager */
    protected $accountManager;

    /**
     * Constructor.
     *
     * @param Request $request
     * @param AccountManager $accountManager
     */
    public function __construct(Request $request, AccountManager $accountManager)
    {
        $this->request        = $request;
        $this->accountManager = $accountManager;
    }

    public function processValid(Account $Account)
    {
        $this->accountManager->update($Account);
    }

    protected function getDefaultObject()
    {
        return $this->accountManager->create();
    }

    protected function getClass()
    {
        return $this->accountManager->getClass();
    }
}