<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Booking
 *
 * @TODO embedded relation too deep
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BookingRepository")
 * @Serializer\ExclusionPolicy("all")
 * @Hateoas\Relation("self", href = "expr('/api/bookings/' ~ object.getId())")
 * @Hateoas\Relation(
 *     "service",
 *     href = "expr('/api/businesses/' ~ object.getService().getBusiness().getSlug() ~ '/services/' ~ object.getService().getId())",
 *     embedded = "expr(object.getService())"
 * )
 * @Hateoas\Relation(
 *     "employee",
 *     href = "expr('/api/employees/' ~ object.getEmployee().getSlug())",
 *     embedded = "expr(object.getEmployee())"
 * )
 * @Hateoas\Relation(
 *     "customer",
 *     href = "expr('/api/customers/' ~ object.getCustomer().getUsername())",
 *     embedded = "expr(object.getCustomer())"
 * )
 */
class Booking
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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Serializer\Type("DateTime")
     * @Serializer\Expose
     */
    protected $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @Serializer\Type("DateTime")
     * @Serializer\Expose
     */
    protected $endDatetime;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     **/
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     **/
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     **/
    protected $employee;

    public function __construct()
    {
    }

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
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * @param \DateTime $startDatetime
     */
    public function setStartDatetime($startDatetime)
    {
        $this->startDatetime = $startDatetime;
    }

    /**
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    /**
     * @param \DateTime $endDatetime
     */
    public function setEndDatetime($endDatetime)
    {
        $this->endDatetime = $endDatetime;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param mixed $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }



}
