<?php

namespace Asso\AMBundle\Entity;

use FOS\UserBundle\Entity\User as FOSUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @orm:Entity
 * @orm:Table(name="ass_user")
 */
class User extends FOSUser
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:ManyToMany(targetEntity="Asso\AMBundle\Entity\Group")
     * @orm:JoinTable(name="ass_user_group")
     */
    protected $groups;
    
    /**
     * @orm:ManyToMany(targetEntity="Asso\AMBundle\Entity\Asso", mappedBy="users")
     */
    protected $assos;
    
    
    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->assos  = new ArrayCollection();
        
        parent::__construct();
    }
    
    public function getAssos()
    {
        return $this->assos;
    }
    public function addAsso(Asso $asso)
    {
        $this->assos[] = $asso;
    }
}