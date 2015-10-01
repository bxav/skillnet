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
 * @ORM\Table(name="employee")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 * @Hateoas\Relation("self", href = "expr('/api/employees/' ~ object.getId())")
 * @Hateoas\Relation(
 *     "business",
 *     href = "expr('/api/businesses/' ~ object.getBusiness().getId())",
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getBusiness() === null)")
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
     * @Serializer\Groups({"read", "write"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"read", "write"})
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"read", "write"})
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"read", "write"})
     */
    protected $speciality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @Serializer\Groups({"read", "write"})
     */
    protected $shortDescription;

    /**
     * @Orm\OneToOne(targetEntity="Image", cascade="all")
     * @Orm\JoinColumn(name="image_id", referencedColumnName="id")
     * @Serializer\Type("AppBundle\Entity\Image")
     * @Serializer\Expose
     * @Serializer\Groups({"read"})
     **/
    protected $image;

    /**
     * @Gedmo\Slug(fields={"firstname", "lastname"})
     * @ORM\Column(length=64, unique=true)
     * @Serializer\Expose
     * @Serializer\Groups({"read"})
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="employees")
     * @ORM\JoinColumn(name="business_id",referencedColumnName="id")
     * @Serializer\Type("AppBundle\Entity\Business")
     * @Serializer\Expose
     * @Serializer\Groups({"read"})
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

    /**
     * @ORM\Column(type="array")
     * @Serializer\Expose
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

    public function __toString() {
        return $this->getFirstname();
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
