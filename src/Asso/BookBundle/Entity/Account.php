<?php

namespace Asso\BookBundle\Entity;

use winzou\BookBundle\Entity\Account as BaseAccount;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;


/**
 * @orm:Entity
 * @orm:Table(name="ass_book_account")
 */
class Account extends BaseAccount
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @orm:ManyToOne(targetEntity="Asso\AMBundle\Entity\Asso")
     */
    protected $wrap;
    
    
    public function setWrap($wrap)
    {
        if( ! $wrap instanceof Asso\AMBundle\Entity\Asso)
        {
            throw new InvalidArgumentException('Expecting instance of Asso\AMBundle\Entity\Asso');
        }
        
        $this->wrap = $wrap;
    }
}