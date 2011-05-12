<?php

namespace winzou\BookBundle\Entity\Manager;

use Doctrine\ORM\EntityRepository;

class EntryManager
{
    protected $em;
    protected $repository;
    protected $class;

    /**
     * Constructor.
     *
     * @param EntityManager  $em
     * @param string         $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository($class);
        $this->class      = $class;
    }
    
    public function addEntry()
}