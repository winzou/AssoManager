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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * EntryFormType
 * @author winzou
 */
class EntryType extends AbstractType
{
    /** @var AmountTransformer */
    private $amountTransformer;
    
    public function __construct($amountTransformer)
    {
        $this->amountTransformer = $amountTransformer;
    }
    
    /**
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('amount', new AmountType($this->amountTransformer))
            ->add('account')
            ->add('date')
            ;
    }
}