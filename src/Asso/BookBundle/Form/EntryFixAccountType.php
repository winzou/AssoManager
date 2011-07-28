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
    /** @var integer */
    protected $wrap_id;


    /**
     * Constructor
     * @param integer $wrap_id
     */
    public function __construct($wrap_id)
    {
        $this->wrap_id = $wrap_id;
    }

    /**
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $wrap_id = $this->wrap_id;

        $builder
            ->add('label')
            ->add('amount')
            ->add('date')
            ->add('account', 'entity', array(
                'class'         => 'AssoBookBundle:Account',
                'query_builder' => function($repo) use($wrap_id) { return $repo->getQueryChoicelist($wrap_id); },
            ))
            ->add('user', 'entity', array(
                'class'         => 'AssoUserBundle:User',
                'query_builder' => function($repo) use($wrap_id) { return $repo->getQueryChoicelist($wrap_id); },
                'required'		=> false
            ))
            ->add('category', 'entity', array(
                'class'         => 'AssoBookBundle:Category',
                'query_builder' => function($repo) use($wrap_id) { return $repo->getQueryChoicelist($wrap_id); }
            ))
            ;
    }

    /**
     * @see Symfony\Component\Form.AbstractType::getDefaultOptions()
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Asso\BookBundle\Entity\Entry',
        );
    }

    /**
     * @see Symfony\Component\Form.AbstractType::getName()
     */
    public function getName()
    {
        return 'asso_book_entry_new';
    }
}