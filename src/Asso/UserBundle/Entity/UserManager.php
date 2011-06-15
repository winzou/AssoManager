<?php

namespace Asso\UserBundle\Entity;

use FOS\UserBundle\Entity\UserManager as BaseUserManager;

class UserManager extends BaseUserManager
{
    /**
     * @param string $username
     * @return \FOS\UserBundle\Entity\User
     */
    public function findUserByUsername($username)
    {
        $qb = $this->repository->createQueryBuilder('u')
            ->addSelect('a')
            ->innerJoin('u.assos', 'a')
            ->where('u.usernameCanonical = :username')
            ->setParameter('username', $this->usernameCanonicalizer->canonicalize($username));
        
        return $qb->getQuery()->getSingleResult();
    }
}