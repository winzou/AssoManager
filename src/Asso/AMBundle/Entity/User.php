<?php

namespace Asso\AMBundle\Entity;

use FOS\UserBundle\Entity\User as FOSUser;

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
     * @orm:ManyToMany(targetEntity="Asso\TestBundle\Entity\Group")
     * @orm:JoinTable(name="fos_user_user_group",
     *      joinColumns={@orm:JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@orm:JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
}