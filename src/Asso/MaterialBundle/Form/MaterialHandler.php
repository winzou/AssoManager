<?php

namespace Asso\MaterialBundle\Form;

use Asso\AbstractBundle\Form\AbstractFormHandler;
use Asso\MaterialBundle\Manager\MaterialManager;
use Asso\MaterialBundle\Entity\Material;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * MaterialHandler
 * @author winzou
 */
class MaterialHandler extends AbstractFormHandler
{
    /** @var Asso\MaterialBundle\Manager\MaterialManager */
    protected $MaterialManager;

    /**
     * Constructor.
     *
     * @param Request $request
     * @param MaterialManager $MaterialManager
     */
    public function __construct(Request $request, MaterialManager $MaterialManager)
    {
        $this->request         = $request;
        $this->MaterialManager = $MaterialManager;
    }

    public function processValid(Material $Material)
    {
        $this->MaterialManager->update($Material);
    }

    public function getDefaultObject()
    {
        return $this->MaterialManager->create();
    }

    public function getClass()
    {
        return $this->MaterialManager->getClass();
    }
}