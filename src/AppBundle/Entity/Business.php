<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Business
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Business
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    protected $website;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    protected $mainService;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $availableBrands;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $paymentMethods;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $disponibilityTimeSlot = 15;

    /**
     * @Orm\OneToOne(targetEntity="Image", cascade="all")
     * @Orm\JoinColumn(name="image_id", referencedColumnName="id")
     **/
    protected $image;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=64, unique=true)
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

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $addresses
     * @ORM\OneToMany(targetEntity="Address", mappedBy="business", cascade="all")
     */
    protected $addresses = [];


    /**
     * @ORM\Column(type="array")
     */
    protected $workingDays = [
        'monday' => [],
        'tuesday' => [],
        'wednesday' => [],
        'thursday' => [],
        'friday' => [],
        'saturday' => [],
        'sunday' => []
    ];

    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->addresses = new ArrayCollection();
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
     * @return integer
     */
    public function getDisponibilityTimeSlot()
    {
        return $this->disponibilityTimeSlot;
    }

    /**
     * @param integer $disponibilityTimeSlot
     */
    public function setDisponibilityTimeSlot($disponibilityTimeSlot)
    {
        $this->disponibilityTimeSlot = $disponibilityTimeSlot;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
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


    public function setWorkingHoursByDay($dayName, $workingHours)
    {
        $startWorkingHour = explode(":", $workingHours[0]);
        $endWorkingHour = explode(":", $workingHours[1]);
        $this->workingDays[$dayName] = [($startWorkingHour[0] * 60) + $startWorkingHour[1], ($endWorkingHour[0] * 60) + $endWorkingHour[1]];
    }

    public function setWorkingDaysHours($workingDaysHours)
    {
        foreach($workingDaysHours as $workingHours) {
            $this->setWorkingHoursByDay($workingHours[0], $workingHours[1]);
        }
    }

    public function getWorkingHours(\DateTimeInterface $date)
    {
        $dayName = lcfirst($date->format("l"));
        $startWorking = clone $date;
        $endWorking = clone $date;

        if (!isset($this->workingDays[$dayName][0]) or !isset($this->workingDays[$dayName][1])) {
            return null;
        }
        $startWorking = $startWorking->setTime(intval($this->workingDays[$dayName][0] / 60), $this->workingDays[$dayName][0] % 60);

        $endWorking = $endWorking->setTime(intval($this->workingDays[$dayName][1] / 60), $this->workingDays[$dayName][1] % 60);

        return [$startWorking, $endWorking];
    }

    /**
     * @return mixed
     */
    public function getWorkingDays()
    {
        return $this->workingDays;
    }

    /**
     * @param mixed $workingDays
     */
    public function setWorkingDays($workingDays)
    {
        $this->workingDays = $workingDays;
    }


    public function getMainAddress()
    {
        foreach ($this->addresses as $address) {
            if ($address->isCurrent()) {
                return $address;
            }
        }
        return null;
    }
}
