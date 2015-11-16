<?php

namespace App\User\Model;

use Sylius\Component\User\Model\User as BaseUser;

class User extends BaseUser implements UserInterface
{

    protected $employee;

    /**
     * @var boolean
     */
    protected $enabled = true;

    /**
     * {@inheritdoc}
     */
    public function getEmployee()
    {
        return $this->customer;
    }
    /**
     * {@inheritdoc}
     */
    public function setEmployee(EmployeeInterface $employee = null)
    {
        if ($this->employee !== $employee) {
            $this->employee = $employee;
            $this->assignUserToEmployee($employee);
        }
    }

    /**
     * @param EmployeeInterface $employee
     */
    protected function assignUserToEmployee(EmployeeInterface $employee = null)
    {
        if (null !== $employee) {
            $employee->setUser($this);
        }
    }
}
