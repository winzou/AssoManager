<?php

namespace Asso\BookBundle\Entity;


/**
 * @orm:Entity
 * @orm:Table(name="ass_book_item_class")
 */
class ItemClass
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:Column(type="string", unique=true)
     *
     * @assert:NotBlank()
     */
    protected $namespace;
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
    public function setNamespace($name)
    {
        $this->name = $namespace;
    }
}