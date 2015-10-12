<?php

namespace AppBundle\Model;

class Availability
{

    protected $date;

    protected $service;

    protected $employees = [];

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    public function addEmployee($employee)
    {
        $this->employees[] = $employee;
    }

    /**
     * @param array $employees
     */
    public function setEmployees($employees)
    {
        $this->employees = $employees;
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


}
