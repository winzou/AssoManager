<?php

namespace Asso\BookBundle\Entity;

use winzou\BookBundle\Entity\Account as BaseAccount;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ass_book_account")
 */
class Account extends BaseAccount
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Asso\AMBundle\Entity\Asso")
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