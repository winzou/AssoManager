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
     */
    protected $name;
    
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getId()
    {
        return $this->id;
    }

}