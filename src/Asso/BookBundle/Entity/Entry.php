<?php

namespace Asso\BookBundle\Entity;


/**
 * @orm:Entity
 * @orm:Table(name="ass_book_entry")
 */
class Entry
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:ManyToOne(targetEntity="Account", inversedBy="entries")
     * @orm:JoinColumn(nullable=false)
     */
    protected $account;
    
    /**
     * @orm:ManyToOne(targetEntity="Asso\AMBundle\Entity\User")
     * @todo Get this dynamic
     */
    protected $user;
    
    /**
     * @orm:ManyToOne(targetEntity="Item")
     */
    protected $item;
    
    /**
     * @orm:Column(type="date")
     */
    protected $date;
    
    /**
     * @orm:Column(type="string")
     *
     * @assert:NotBlank()
     */
    protected $label;
    
    /**
     * @orm:Column(type="decimal", scale="2")
     */
    protected $amount;
    
    public function __construct()
    {
        $this->date = new \Datetime();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getAccount()
    {
        return $this->account;
    }
    public function setAccount(Account $account)
    {
        $account->addEntry($this);
        $this->account = $account;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    public function setUser(\Symfony\Component\Security\Core\User\UserInterface $user = null)
    {
        $this->user = $user;
    }
    
    public function getItem()
    {
        return $this->item;
    }
    public function setItem(Item $item = null)
    {
        $this->item = $item;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    public function setDate(\Datetime $date)
    {
        $this->date = $date;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    public function setLabel($label)
    {
        $this->label = $label;
    }
    
    public function getAmount()
    {
        return $this->amount;
    }
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}