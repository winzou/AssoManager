<?php
namespace Asso\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DocType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('price', 'money', array('currency' => 'EUR'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Asso\TestBundle\Entity\Doc',
        );
    }
}