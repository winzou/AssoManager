<?php

namespace Asso\MaterialBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Asso\MaterialBundle\Manager\LeaseManager")
 * @ORM\Table(name="ass_material_lease")
 */
class Lease
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Asso\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Asso\MaterialBundle\Entity\Material")
     */
    protected $material;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\Date
     */
    protected $start_date;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\Date
     */
    protected $end_date;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\Date
     */
    protected $intended_start_date;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\Date
     */
    protected $intended_end_date;

    /**
     * @ORM\Column(type="string")
     */
    protected $label;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Get Material
     * @return Material
     */
    public function getMaterial()
    {
        return $this->material;
    }
    /**
     * Set Material
     * @param Material $material
     */
    public function setMaterial(Material $material)
    {
        $this->material = $material;
    }

    /**
     * Get user
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Set user
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;
    }

    /**
     * Get startDate
     * @return \Datetime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }
    /**
     * Set startDate
     * @param \Datetime $date
     */
    public function setStartDate(\Datetime $date)
    {
        $this->start_date = $date;
    }

	/**
     * Get endDate
     * @return \Datetime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }
    /**
     * Set endDate
     * @param \Datetime $date
     */
    public function setEndDate(\Datetime $date)
    {
        $this->end_date = $date;
    }

	/**
     * Get indentedStartDate
     * @return \Datetime
     */
    public function getIntendedStartDate()
    {
        return $this->intended_start_date;
    }
    /**
     * Set indentedStartDate
     * @param \Datetime $date
     */
    public function setIntendedStartDate(\Datetime $date)
    {
        $this->intended_start_date = $date;
    }

	/**
     * Get indentedEndDate
     * @return \Datetime
     */
    public function getIntendedEndDate()
    {
        return $this->intended_end_date;
    }
    /**
     * Set indentedEndDate
     * @param \Datetime $date
     */
    public function setIntendedEndDate(\Datetime $date)
    {
        $this->intended_end_date = $date;
    }

	/**
     * Get label
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    /**
     * Set label
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }
}