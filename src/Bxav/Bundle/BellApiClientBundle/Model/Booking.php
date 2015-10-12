<?php

namespace Bxav\Bundle\BellApiClientBundle\Model;

class Booking
{

    protected $id;

    protected $startDatetime;

    protected $endDatetime;

    protected $price;

    protected $personalized = false;

    protected $customerNote;

    protected $employeeNote;

    protected $customer;

    protected $service;

    protected $employee;

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
