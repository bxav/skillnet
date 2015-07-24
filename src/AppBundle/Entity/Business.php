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
     * @ORM\Column(type="text",nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=64, unique=true)
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="business", cascade="all")
     */
    protected $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
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

    public function __toString() {
        return $this->getName();
    }
}
