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

use Asso\BookBundle\Manager\EntryManager;
use Asso\BookBundle\Entity\Entry;

/**
 * EntryHandler
 * @author winzou
 */
class EntryHandler
{
    protected $request;
    protected $entryManager;
    protected $form;

    /**
     * Constructor.
     *
     * @param Form $form
     * @param Request $request
     * @param EntryManager $entryManager
     */
    public function __construct(Form $form, Request $request, EntryManager $entryManager)
    {
        $this->form         = $form;
        $this->request      = $request;
        $this->entryManager = $entryManager;
    }

    /**
     * Process the form
     *
     * @param Entry $entry
     * @return bool
     */
    public function process(Entry $entry = null)
    {
        if( $entry === null )
        {
            $entry = $this->entryManager->createEntry();
        }

        $this->form->setData($entry);

        if( 'POST' == $this->request->getMethod() )
        {
            $this->form->bindRequest($this->request);

            if( $this->form->isValid() )
            {
                $this->entryManager->updateEntry($entry);

                return true;
            }
        }

        return false;
    }
}