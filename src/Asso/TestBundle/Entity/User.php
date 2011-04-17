<?php

namespace Asso\TestBundle\Entity;
use FOS\UserBundle\Entity\User as FOSUser;

/**
 * @orm:Entity
 */
class User extends FOSUser
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;

}