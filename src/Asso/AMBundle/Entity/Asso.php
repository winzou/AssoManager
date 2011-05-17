<?php

namespace Asso\AMBundle\Entity;


/**
 * @orm:Entity
 * @orm:Table(name="ass_asso")
 */
class Asso
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:Column(type="string",unique="true",length="32")
     *
     * @assert:NotBlank()
     * @assert:MaxLength(32)
     */
    protected $name;
    
    /**
     * @orm:ManyToMany(targetEntity="User", inversedBy="assos")
     * @orm:JoinTable(name="ass_asso_user")
     */
    protected $users;
    
    
    public function __construct()
    {
        $this->users  = new Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->getName();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getUsers()
    {
        return $this->users;
    }
    public function addUser(User $user)
    {
        $user->addAsso($this);
        $this->users[] = $user;
    }
}