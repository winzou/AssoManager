<?php

namespace Asso\AMBundle\Entity;

use Asso\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ass_asso")
 */
class Asso
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string",unique="true",length="32")
     *
     * @Assert\NotBlank()
     * @Assert\MaxLength(32)
     */
    protected $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="Asso\UserBundle\Entity\User", inversedBy="assos")
     * @ORM\JoinTable(name="ass_asso_user")
     */
    protected $users;
    
    
    public function __construct()
    {
        $this->users  = new ArrayCollection();
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