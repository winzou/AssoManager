<?php

namespace Asso\TestBundle\Entity;

use FOS\UserBundle\Entity\Group as BaseGroup;

/**
 * @orm:Entity
 * @orm:Table(name="ass_group")
 */
class Group extends BaseGroup
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
}