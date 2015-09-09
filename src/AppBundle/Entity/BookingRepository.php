<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class BookingRepository extends EntityRepository
{
    public function findByDateAndEmployee(\DateTimeImmutable $date, $employee)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.employee = :employee')
            ->andWhere('b.startDatetime BETWEEN :start AND :end')
            ->setParameter('employee', $employee)
            ->setParameter('start', $date->setTime(0,0)->format('Y-m-d H:i:s'))
            ->setParameter('end', $date->setTime(23, 59, 59)->format('Y-m-d H:i:s'))
            ->orderBy('b.startDatetime', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}
