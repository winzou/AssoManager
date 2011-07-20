<?php

/*
 * This file is part of AssoBookBundle.
 *
 * AssoBookBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AssoBookBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asso\BookBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * AmountModel
 * @author winzou
 *
 * @Annotation
 * @Assert\Callback(methods={"isCreditValid"})
 */
class AmountModel
{
    /**
     * @Assert\Min(5)
     */
    private $debit;

    /**
     * @Assert\Min(0)
     */
    private $credit;


    public function setDebit($debit)
    {
        $this->debit = $debit;
    }
    public function getDebit()
    {
        return $this->debit;
    }

    public function setCredit($credit)
    {
        $this->credit = $credit;
    }
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @Assert\True(message = "The token is invalid")
     */
    public function isCreditValid()
    {exit('lala');return false;
        if( $this->getDebit() != 0 AND $this->getCredit() != 0 )
        {
            //$property_path = $context->getPropertyPath() . '.firstName';
            //$context->setPropertyPath($property_path);
            $context->addViolation('Please fill in either debit either credit but not both.', array(), null);
        }
    }
}