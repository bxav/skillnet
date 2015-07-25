<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class BookingRepository extends EntityRepository
{
    public function findAllByEmployee(Employee $employee)
    {
        $query = $this->createQueryBuilder('b')
            ->leftJoin('b.service', 's')
            ->where('s.employee = :employee')
            ->setParameter('employee', $employee);
        return $query->getQuery()->getResult();
    }
}
