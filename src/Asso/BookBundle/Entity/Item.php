<?php

namespace Asso\BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @orm:Entity
 * @orm:Table(name="ass_book_item")
 */
class Item
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:ManyToOne(targetEntity="ItemClass")
     */
    protected $class;
    
    /**
     * @orm:Column(type="integer", name="object_id")
     */
    protected $objectId;
    
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getClass()
    {
        return $this->class;
    }
    public function setClass(ItemClass $class)
    {
        $this->class = $class;
    }
    
    public function getObjectId()
    {
        return $this->objectId;
    }
    public function setObjectId($id)
    {
        $this->objectId = $id;
    }
}