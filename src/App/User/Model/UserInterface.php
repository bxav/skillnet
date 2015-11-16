<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This model was inspired by FOS User-Bundle
 */

namespace App\User\Model;


interface UserInterface extends \Sylius\Component\User\Model\UserInterface
{

    /**
     * @return EmployeeInterface
     */
    public function getEmployee();

    /**
     * @param EmployeeInterface $customer
     */
    public function setEmployee(EmployeeInterface $employee = null);
}
