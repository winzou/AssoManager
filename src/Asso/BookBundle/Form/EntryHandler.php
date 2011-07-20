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
use Asso\BookBundle\Manager\EntryManager;
use Asso\BookBundle\Entity\Entry;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * EntryHandler
 * @author winzou
 */
class EntryHandler extends AbstractFormHandler
{
    /** @var Asso\BookBundle\Manager\EntryManager */
    protected $entryManager;

    /**
     * Constructor.
     *
     * @param Request $request
     * @param EntryManager $entryManager
     */
    public function __construct(Request $request, EntryManager $entryManager)
    {
        $this->request      = $request;
        $this->entryManager = $entryManager;
    }

    public function processValid(Entry $entry)
    {
        $this->entryManager->update($entry);
    }

    public function getDefaultObject()
    {
        return $this->entryManager->create();
    }

    public function getClass()
    {
        return $this->entryManager->getClass();
    }
}