<?php

namespace Asso\TestBundle\Entity;

/**
 * @orm:Entity
 */
class User
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @orm:Column(type="string", length="50")
     */
    protected $name;
    
    
    public function setName ( $name )
    {
    	$this->name = $name;
    }
    
    public function getName ( )
    {
    	return $this->name;
    }
}