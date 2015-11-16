<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Booking
 *
 * @TODO embedded relation too deep
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BookingRepository")
 * @Hateoas\Relation("self", href = "expr('/api/bookings/' ~ object.getId())")
 * @Hateoas\Relation(
 *     "service",
 *     href = "expr('/api/businesses/' ~ object.getService().getBusiness().getId() ~ '/services/' ~ object.getService().getId())",
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getService() === null)")
 * )
 * @Hateoas\Relation(
 *     "employee",
 *     href = "expr('/api/employees/' ~ object.getEmployee().getId())",
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getEmployee() === null)")
 * )
 * @Hateoas\Relation(
 *     "customer",
 *     href = "expr('/api/customers/' ~ object.getCustomer().getId())",
 *     exclusion = @Hateoas\Exclusion(excludeIf = "expr(object.getCustomer() === null)")
 * )
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $endDatetime;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $personalized = false;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $customerNote;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $employeeNote;

    /**
     * @ORM\ManyToOne(targetEntity="Customer")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=true)
     **/
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id", nullable=true)
     **/
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="Employee")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id", nullable=true)
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
     * @return boolean
     */
    public function isPersonalized()
    {
        return $this->personalized == true;
    }

    /**
     * @param boolean $personalized
     */
    public function setPersonalized($personalized)
    {
        $this->personalized = $personalized;
    }

    /**
     * @return string
     */
    public function getCustomerNote()
    {
        return $this->customerNote;
    }

    /**
     * @param string $customerNote
     */
    public function setCustomerNote($customerNote)
    {
        $this->customerNote = $customerNote;
    }

    /**
     * @return string
     */
    public function getEmployeeNote()
    {
        return $this->employeeNote;
    }

    /**
     * @param string $employeeNote
     */
    public function setEmployeeNote($employeeNote)
    {
        $this->employeeNote = $employeeNote;
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
    public function setCustomer(Customer $customer)
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
    public function setService(Service $service)
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
    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;
    }



}
