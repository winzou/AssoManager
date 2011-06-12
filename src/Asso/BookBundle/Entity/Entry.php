<?php

namespace Asso\BookBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ass_book_entry")
 */
class Entry
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Asso\UserBundle\Entity\User")
     */
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Asso\BookBundle\Entity\Account")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    protected $account;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $created_at;
    
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $label;
    
    /**
     * @ORM\Column(type="decimal", scale="2")
     */
    protected $amount;
    
    
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->created_at = new \Datetime();
    }
    
    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get Account
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }
    /**
     * Set Account
     * @param Account $account
     */
    public function setAccount(Account $account)
    {
        $this->account = $account;
    }
    
    /**
     * Get user
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Set user
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;
    }
    
    /**
     * Get created_at
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    /**
     * Set created_at
     * @param \Datetime $createdAt
     */
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->created_at = $createdAt;
    }
    
    /**
     * Get label
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    /**
     * Set label
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    /**
     * Get amount
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }
    
    /**
     * Set amount
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}