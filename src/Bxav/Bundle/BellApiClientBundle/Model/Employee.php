<?php

namespace Bxav\Bundle\BellApiClientBundle\Model;

class Employee
{

    protected $id;

    protected $firstname;

    protected $lastname;

    protected $speciality;

    protected $shortDescription;

    protected $image;

    protected $business;

    protected $services;

    protected $workingDays = [
        'monday' => [],
        'tuesday' => [],
        'wednesday' => [],
        'thursday' => [],
        'friday' => [],
        'saturday' => [],
        'sunday' => []
    ];

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getBusiness()
    {
        return $this->business;
    }

    /**
     * @param mixed $business
     */
    public function setBusiness(Business $business)
    {
        $this->business = $business;
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


    public function __toString()
    {
        return (string) $this->getUsername();
    }

}
