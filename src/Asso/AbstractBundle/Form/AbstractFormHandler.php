<?php

namespace Asso\AbstractBundle\Form;

/**
 * AbstractFormHandler
 * @author winzou
 */
abstract class AbstractFormHandler
{
    /* @var Symfony\Component\HttpFoundation\Request */
    protected $request;
    
    /* @var Symfony\Component\Form\Form */
    protected $form;
    
    
    /**
     * Return an instance of the currently handled object, filled in with the default values
     */
    abstract protected function getDefaultObject();
    
    /**
     * Return the class of the currently handled object
     *
     * @return string
     */
    abstract protected function getClass();
    
    
    /**
     * Process the form
     *
     * @param $object
     * @return bool
     */
    public function process($object = null)
    {
        // if null we fill
        if( $object === null )
        {
            $object = $this->getDefaultObject();
        }
        // elseif not handled by this handler, exception
        elseif( ! is_a($object, $this->getClass()) )
        {
            throw new InvalidExceptionArgument('Argument must be an instance of '.$class);
        }
        
        $this->form->setData($object);

        if( $this->request->getMethod() == 'POST' )
        {
            $this->form->bindRequest($this->request);

            if( $this->form->isValid() )
            {
                $this->processValid($object);

                return true;
            }
        }

        return false;
    }

    /**
     * Return the object handled
     *
     * @return instanceof $this->getClass()
     */
    public function getFormData()
    {
        return $this->form->getData();
    }
    
    /**
     * Return the view of the form
     *
     * @return Symfony\Component\Form\FormView
     */
    public function getFormView()
    {
        return $this->form->createView();
    }
}