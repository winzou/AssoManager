<?php

namespace Asso\BookBundle\Entity;

use winzou\BookBundle\Entity\Entry as BaseEntry;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ass_book_entry")
 */
class Entry extends BaseEntry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Asso\AMBundle\Entity\User")
     */
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Asso\BookBundle\Entity\Account")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $account;
}