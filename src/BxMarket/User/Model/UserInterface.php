<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BxMarket\User\Model;

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
