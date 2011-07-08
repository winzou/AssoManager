<?php

namespace Asso\AbstractBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Abstract Entity Manager
 * @author winzou
 */
abstract class AbstractManager
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @var Doctrine\ORM\EntityRepository
     */
    protected $repository;
    
    /**
     * @var string
     */
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
        
        $this->class = $em->getClassMetadata($class)->name;
    }
    
    /**
     * Return one row with all associations done
     * @param int $id
     * @param bool $array
     * @return $this->class
     */
    public function getFullOne($id)
    {
        try {
            $qb = $this->repository->createQueryBuilder('e');
            
            $qb = $this->addAssociations($qb);
            
            $qb ->where('e.id = :id')
                ->setParameter('id', $id);
            
            return $qb->getQuery()->getSingleResult();
        }
        catch( NoResultException $e ) {
            throw new NotFoundHttpException($this->class.'[id='.$id.'] not found', $e->getPrevious());
        }
    }
    
    /**
     * Create an instance of the managed entity
     * @return $this->class
     */
    protected function create()
    {
        $class = $this->class;
        return new $class;
    }
    
    /**
     * Delete the given entity
     * @param $this->class $entity
     */
    protected function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
    
    /**
     * Update the given entity, and flush the EM if asked to
     *
     * @param $this->class $entity
     * @param bool $andFlush
     */
    protected function update($entity, $andFlush = true)
    {
        $this->em->persist($entity);
        
        if( $andFlush )
        {
            $this->em->flush();
        }
    }
    
    /**
     * Add requested associations to given QueryBuilder
     * @param QueryBuilder $qb
     * @param array $associations
     * @return QueryBuilder
     */
    protected function addAssociations(QueryBuilder $qb, array $associations = array())
    {
        foreach( $this->em->getClassMetadata($this->class)->associationMappings as $name => $rel )
        {
            // check if @param is empty (means we join all associations) or if current $name is requested by @param
            if( ! $associations OR in_array($name, $associations) )
            {
                $qb->leftJoin($qb->getRootAlias().'.'.$rel['fieldName'], $rel['fieldName']);
                $qb->addSelect($rel['fieldName']);
            }
        }
        
        return $qb;
    }
    
    /**
     * Return the supported class
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}