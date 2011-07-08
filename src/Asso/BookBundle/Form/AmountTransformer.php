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

use Symfony\Component\Form\DataTransformerInterface;

class AmountTransformer implements DataTransformerInterface
{
    /**
     * Transforms a ParticipantInterface instance to a username string
     *
     * @param mixed $value a ParticipantInterface instance
     * @return string the username
     */
    public function transform($value)
    {
        return ( $value['credit'] - $value['debit'] );
    }

    /**
     * Transforms a username to a ParticipantInterface instance
     *
     * @param string $username
     * @return ParticipantInterface the corresponding user instance
     */
    public function reverseTransform($value)
    {
        $amount = array();
        
        if( $value < 0 )
        {
            $amount['debit'] = -$value;
            $amount['credit'] = 0;
        }
        else
        {
            $amount['credit'] = $value;
            $amount['debit'] = 0;
        }
        
        return $amount;
    }
}