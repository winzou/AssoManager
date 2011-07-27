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
abstract class AbstractManager extends EntityRepository
{
    /**
     * Return one row with all associations done
     * @param int $id
     * @param bool $array
     * @return instanceof $this->_entityName
     */
    public function getFullOne($id)
    {
        $qb = $this->createQueryBuilder('e');

        $qb = $this->addAssociations($qb);

        $qb ->where('e.id = :id')
            ->setParameter('id', $id);

        try {
            return $qb->getQuery()->getSingleResult();
        }
        catch( NoResultException $e ) {
            throw new NotFoundHttpException($this->_entityName.'[id='.$id.'] not found', $e->getPrevious());
        }
    }

    /**
     * Create an instance of the managed entity
     * @return instanceof $this->_entityName
     */
    public function create()
    {
        $class = $this->_entityName;
        return new $class;
    }

    /**
     * Delete the given entity
     * @param $this->_entityName $entity
     * @throws \InvalidArgumentException
     */
    public function delete($entity, $andFlush = true)
    {
        if( ! $entity instanceof $this->_entityName )
        {
            throw new \InvalidArgumentException('Except instanceof "'.$this->_entityName.'", received instanceof "'.get_class($entity).'".');
        }

        $this->_em->remove($entity);

        if( $andFlush )
        {
            $this->_em->flush();
        }
    }

    /**
     * Update the given entity, and flush the EM if asked to
     *
     * @param $this->_entityName $entity
     * @param bool $andFlush
     * @throws \InvalidArgumentException
     */
    public function update($entity, $andFlush = true)
    {
        if( ! $entity instanceof $this->_entityName )
        {
            throw new \InvalidArgumentException('Except instanceof "'.$this->_entityName.'", received instanceof "'.get_class($entity).'".');
        }

        $this->_em->persist($entity);

        if( $andFlush )
        {
            $this->_em->flush();
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
        foreach( $this->_class->associationMappings as $name => $rel )
        {
            // check if @param is empty (means we join all associations) or if current $name is requested by @param
            if( ! $associations OR in_array($name, $associations) )
            {
                /** @todo check if column can be null, and if so only, use leftjoin */
                $qb->leftJoin(current($qb->getRootAliases()).'.'.$rel['fieldName'], $rel['fieldName']);
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
        return $this->_entityName;
    }
}