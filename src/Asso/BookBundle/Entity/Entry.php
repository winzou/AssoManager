<?php

namespace Asso\BookBundle\Entity;

use \winzou\BookBundle\Entity\Entry as BaseEntry;

use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * @orm:Entity
 * @orm:Table(name="ass_book_entry")
 */
class Entry extends BaseEntry
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:ManyToOne(targetEntity="Asso\AMBundle\Entity\User")
     */
    protected $user;
    
    /**
     * @orm:ManyToOne(targetEntity="Asso\BookBundle\Entity\Account")
     * @orm:JoinColumn(nullable=false)
     */
    protected $account;
}