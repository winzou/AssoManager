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

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

use Asso\BookBundle\Manager\AccountManager;
use Asso\BookBundle\Entity\Account;

/**
 * AccountHandler
 * @author winzou
 */
class AccountHandler
{
    protected $request;
    protected $accountManager;
    protected $form;

    /**
     * Constructor.
     *
     * @param Form $form
     * @param Request $request
     * @param AccountManager $accountManager
     */
    public function __construct(Form $form, Request $request, AccountManager $accountManager)
    {
        $this->form           = $form;
        $this->request        = $request;
        $this->accountManager = $accountManager;
    }

    /**
     * Process the form
     *
     * @param Account $Account
     * @return bool
     */
    public function process(Account $Account = null)
    {
        if( $Account === null )
        {
            $Account = $this->accountManager->createAccount();
        }

        $this->form->setData($Account);

        if( 'POST' == $this->request->getMethod() )
        {
            $this->form->bindRequest($this->request);

            if( $this->form->isValid() )
            {
                $this->accountManager->updateAccount($Account);

                return true;
            }
        }

        return false;
    }
}