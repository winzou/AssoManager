<?php

namespace Asso\UserBundle;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use FOS\UserBundle\Util\CanonicalizerInterface;

use Doctrine\ORM\EntityManager;

class UserProvider implements UserProviderInterface
{
    /** @var $em */
    protected $em;
    
    /** @var $usernameCanonicalizer */
    protected $usernameCanonicalizer;
    
    /** @var string */
    protected $class;
    
    public function __construct(EntityManager $em, CanonicalizerInterface $usernameCanonicalizer, $class)
    {
        $this->em    = $em;
        $this->class = $class;
        
        $this->usernameCanonicalizer = $usernameCanonicalizer;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Security\Core\User.UserProviderInterface::loadUserByUsername()
     */
    public function loadUserByUsername($username)
    {
        $user = $this->em->getRepository($this->class)
            ->createQueryBuilder('u')
            ->addSelect('a')
            ->innerJoin('u.assos', 'a')
            ->where('u.usernameCanonical = :username')
            ->setParameter('username', $this->usernameCanonicalizer->canonicalize($username))
            ->getQuery()
            ->getSingleResult();

        if( ! $user )
        {
            throw new UsernameNotFoundException(sprintf('No user with name "%s" was found.', $username));
        }

        return $user;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Security\Core\User.UserProviderInterface::loadUser()
     */
    public function loadUser(SecurityUserInterface $user)
    {
        if( ! $user instanceof $this->class)
        {
            throw new UnsupportedUserException('Account is not supported (expecting '.$this->class.')');
        }

        return $this->loadUserByUsername($user->getUsername());
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Security\Core\User.UserProviderInterface::supportsClass()
     */
    public function supportsClass($class)
    {
        return $this->class;
    }
}