<?php

namespace AppBundle\User\Model;

use Sylius\Component\Resource\Model\SoftDeletableInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\User\Model\UserAwareInterface;

interface EmployeeInterface extends UserAwareInterface, TimestampableInterface, SoftDeletableInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return boolean
     */
    public function hasUser();

    /**
     * Gets first and last name.
     *
     * @return string
     */
    public function getFullName();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param  string $firstName
     */
    public function setFirstName($firstName);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param  string $lastName
     */
    public function setLastName($lastName);
}
