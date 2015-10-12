<?php

namespace Bxav\Bundle\BellApiClientBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Business
 *
 * @ORM\Table()
 * @ORM\Model
 */
class Business
{

    protected $id;

    protected $name;

    protected $website;

    protected $phone;

    protected $email;

    protected $address;

    protected $mainService;

    protected $availableBrands;

    protected $paymentMethods;

    protected $description;

    protected $disponibilityTimeSlot = 15;

    protected $image;

    protected $slug;

    protected $employees = [];

    protected $services = [];

    protected $workingDays = [
        'monday' => [],
        'tuesday' => [],
        'wednesday' => [],
        'thursday' => [],
        'friday' => [],
        'saturday' => [],
        'sunday' => []
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

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
    public function setImage($image)
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

    public function setEmployees($employees)
    {
        $this->employees = $employees;
        return $this;
    }

    public function getEmployees()
    {
        return $this->employees;
    }

    public function setServices($services)
    {
        $this->services = $services;
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


}
