<?php

namespace Asso\BookBundle\Entity;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ass_book_account")
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Asso\AMBundle\Entity\Asso")
     */
    protected $wrap;
    
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $name;
    
    
    /**
     * Dump the name
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Get wrap
     */
    public function getWrap()
    {
        return $this->wrap;
    }
    /**
     * Set wrap
     * @param Asso $wrap
     */
    public function setWrap(Asso $wrap)
    {
        $this->wrap = $wrap;
    }
    
    /**
     * Get name
	 * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}