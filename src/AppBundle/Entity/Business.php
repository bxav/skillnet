<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Business
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Business
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $website;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $mainService;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $availableBrands;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $paymentMethods;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=64, unique=true)
     * @Serializer\Expose
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="business", cascade="all")
     */
    protected $employees;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="business", cascade="all")
     */
    protected $services;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getMainService()
    {
        return $this->mainService;
    }

    /**
     * @param mixed $mainService
     */
    public function setMainService($mainService)
    {
        $this->mainService = $mainService;
    }

    /**
     * @return mixed
     */
    public function getAvailableBrands()
    {
        return $this->availableBrands;
    }

    /**
     * @param mixed $availableBrands
     */
    public function setAvailableBrands($availableBrands)
    {
        $this->availableBrands = $availableBrands;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    /**
     * @param mixed $paymentMethods
     */
    public function setPaymentMethods($paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function hasEmployees()
    {
        return !$this->employees->isEmpty();
    }

    public function removeEmployee(Employee $employee)
    {
        $this->employees->removeElement($employee);
    }

    public function addEmployee(Employee $employee)
    {
        $employee->setBusiness($this);
        $this->employees->add($employee);
    }
    public function setEmployees($employees)
    {
        $this->employees = $employees;
        $this->employees->clear();
        foreach ($employees as $employee) {
            $this->addEmployee($employee);
        }
        return $this;
    }

    public function getEmployees()
    {
        return $this->employees;
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
        $service->setBusiness($this);
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
        return $this->getName();
    }
}
