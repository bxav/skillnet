<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Employee
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Type("integer")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $speciality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $shortDescription;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="employees")
     * @ORM\JoinColumn(name="employee_id",referencedColumnName="id")
     */
    protected $business;

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * @param mixed $speciality
     */
    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;
    }

    /**
     * @return mixed
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param mixed $shortDescription
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @return mixed
     */
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param mixed $business
     */
    public function setBusiness($business)
    {
        $this->business = $business;
    }


}
