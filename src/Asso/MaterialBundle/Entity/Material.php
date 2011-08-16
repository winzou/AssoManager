<?php

namespace Asso\MaterialBundle\Entity;

use Asso\AMBundle\Entity\Asso;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Asso\MaterialBundle\Entity\MaterialRepository")
 * @ORM\Table(name="ass_material")
 */
class Material
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Asso\MaterialBundle\Entity\Lease", mappedBy="material")
     */
    protected $leases;

    /**
     * @ORM\ManyToOne(targetEntity="Asso\AMBundle\Entity\Asso")
     */
    protected $asso;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     */
    protected $name;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->leases = new ArrayCollection();
    }

    /**
     * Dump the name
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get leases
     */
    public function getLeases()
    {
        return $this->leases;
    }
    /**
     * Add leases
     * @param Lease $user
     */
    public function addLease(Lease $lease)
    {
        $this->leases[] = $lease;
    }

	/**
     * Get Asso
     * @return Asso
     */
    public function getAsso()
    {
        return $this->asso;
    }
    /**
     * Set Asso
     * @param Asso $asso
     */
    public function setAsso(Asso $asso)
    {
        $this->asso = $asso;
    }

    /**
     * Get name
	 * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}