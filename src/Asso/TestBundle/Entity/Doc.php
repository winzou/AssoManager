<?php

namespace Asso\TestBundle\Entity;

/**
 * @orm:Entity
 */
class Doc
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:Column(type="string")
     *
     * @assert:NotBlank()
     * @assert:MinLength(3)
     */
    protected $name;
    
    /**
     * @orm:Column(type="integer")
     *
     * @assert:NotBlank()
     * @assert:Min(0)
     */
    protected $price;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    public function getId()
    {
        return $this->id;
    }

}