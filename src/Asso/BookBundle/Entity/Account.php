<?php

namespace Asso\BookBundle\Entity;


/**
 * @orm:Entity
 * @orm:Table(name="ass_book_account")
 */
class Account
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @todo Get this dynamic
     * @orm:ManyToOne(targetEntity="Asso\AMBundle\Entity\Asso")
     */
    protected $wrap;
    
    /**
     * @OneToMany(targetEntity="Entry", mappedBy="account")
     */
    protected $entries;
    
    /**
     * @orm:Column(type="string")
     *
     * @assert:NotBlank()
     */
    protected $name;
    
    
    public function __construct()
    {
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getWrap()
    {
        return $this->wrap;
    }
    /** @todo Get this dynamic */
    public function setWrap(\Asso\AMBundle\Entity\Asso $wrap)
    {
        $this->wrap = $wrap;
    }
    
    public function getEntries()
    {
        return $this->entries;
    }
    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;
    }
    
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
}