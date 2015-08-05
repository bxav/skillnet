<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Service
 *
 * @ORM\Table()
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Service
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
     * @ORM\Column(type="integer")
     * @Serializer\Type("integer")
     * @Serializer\Expose
     */
    protected $duration;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Type("string")
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="services")
     * @ORM\JoinColumn(name="business_id",referencedColumnName="id")
     */
    protected $business;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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

    public function __toString()
    {
        return " " . $this->getId();
    }
}
