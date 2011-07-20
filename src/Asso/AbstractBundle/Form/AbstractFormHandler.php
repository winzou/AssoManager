<?php

namespace Asso\AbstractBundle\Form;

use Symfony\Component\Form\Form;

/**
 * AbstractFormHandler
 * @author winzou
 */
abstract class AbstractFormHandler
{
    /* @var Symfony\Component\HttpFoundation\Request */
    protected $request;


    /**
     * Return an instance of the currently handled object, filled in with the default values
     *
     * @return instanceof $this->getClass()
     */
    abstract public function getDefaultObject();

    /**
     * Return the class of the currently handled object
     *
     * @return string
     */
    abstract public function getClass();


    /**
     * Process the form
     *
     * @param $object
     * @return bool
     */
    public function process(Form $form, $object = null)
    {
        if( $object !== null )
        {
            // check if $object is handled by this handler
            if( ! is_a($object, $this->getClass()) )
            {
                throw new \InvalidArgumentException('Argument must be an instance of "'.$this->getClass().'", "'.get_class($object).'" given.');
            }

            $form->setData($object);
        }

        if( $this->request->getMethod() == 'POST' )
        {
            $form->bindRequest($this->request);

            if( $form->isValid() )
            {
                $this->processValid($form->getData());

                return true;
            }
        }

        return false;
    }
}