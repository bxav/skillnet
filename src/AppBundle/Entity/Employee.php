<?php

namespace AppBundle\Entity;

use AppBundle\Model\UserTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity
 */
class Employee extends \AppBundle\User\Model\Employee
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
     * @ORM\Column(type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $speciality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $shortDescription;

    /**
     * @Orm\OneToOne(targetEntity="Image", cascade="all")
     * @Orm\JoinColumn(name="image_id", referencedColumnName="id")
     **/
    protected $image;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="employees")
     * @ORM\JoinColumn(name="business_id",referencedColumnName="id")
     */
    protected $business;

    /**
     * @ORM\ManyToMany(targetEntity="Service", inversedBy="employees")
     * @ORM\JoinTable(name="employees_services")
     **/
    protected $services;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="employee")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;

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
        parent::__construct();
        $this->services = new ArrayCollection();
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
        return (string) $this->getUser()->getUsername();
    }

}
