<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Employee
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 * @Hateoas\Relation("self", href = "expr('/api/employees/' ~ object.getSlug())")
 * @Hateoas\Relation(
 *     "business",
 *     href = "expr('/api/businesses/' ~ object.getBusiness().getSlug())",
 *     embedded = "expr(object.getBusiness())"
 * )
 */
class Employee extends User
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
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $lastname;

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
     * @Gedmo\Slug(fields={"firstname", "lastname"})
     * @ORM\Column(length=64, unique=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="employees")
     * @ORM\JoinColumn(name="business_id",referencedColumnName="id")
     */
    protected $business;

    /**
     * @ORM\ManyToMany(targetEntity="Service")
     * @ORM\JoinTable(name="employees_services",
     *      joinColumns={@ORM\JoinColumn(name="employee_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="service_id", referencedColumnName="id")}
     *      )
     **/
    protected $services;

    public function __construct()
    {
        parent::__construct();
        $this->services = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
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
    public function getSlug()
    {
        return $this->slug;
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

    public function hasServices()
    {
        return !$this->services->isEmpty();
    }

    public function removeService(Service $service)
    {
        $this->services->removeElement($service);
    }

    public function addService(Service $service)
    {
        $this->services->add($service);
    }

    public function setServices($services)
    {
        $this->services = $services;
        $this->services->clear();
        foreach ($services as $service) {
            $this->addService($service);
        }
        return $this;
    }

    public function getServices()
    {
        return $this->services;
    }

    public function __toString() {
        return $this->getFirstname();
    }
}
