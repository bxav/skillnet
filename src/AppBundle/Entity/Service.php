<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Product\Model\Product;

/**
 * Service.
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ServiceRepository")
 */
class Service extends Product
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    /**
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $description;

    /**
     * @Orm\OneToOne(targetEntity="Image", cascade="all")
     * @Orm\JoinColumn(name="image_id", referencedColumnName="id")
     **/
    protected $image;

    /**
     * @ORM\ManyToOne(targetEntity="Business", inversedBy="services")
     * @ORM\JoinColumn(name="business_id",referencedColumnName="id")
     */
    protected $business;

    /**
     * @ORM\ManyToMany(targetEntity="Employee", mappedBy="services")
     **/
    protected $employees;

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
        return ' '.$this->getId();
    }
}
