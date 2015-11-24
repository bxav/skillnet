<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Pagerfanta\PagerfantaInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

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

    public function findByEmployeeAndBetween($employee, \DateTimeImmutable $start, \DateTimeImmutable $end)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.employee = :employee')
            ->andWhere('b.startDatetime BETWEEN :start AND :end')
            ->setParameter('employee', $employee)
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->orderBy('b.startDatetime', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Create filter paginator.
     *
     * @param array $criteria
     * @param array $sorting
     *
     * @return PagerfantaInterface
     */
    public function createFilterPaginator($criteria = array(), $sorting = array())
    {
        $queryBuilder = $this->getCollectionQueryBuilder();

        if (!empty($criteria['employee'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('b.employee', ':employee'))
                ->setParameter('employee', $criteria['employee'])
            ;
        }

        if (!empty($criteria['customer'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('b.customer', ':customer'))
                ->setParameter('customer', $criteria['customer'])
            ;
        }

        return $this->getPaginator($queryBuilder);
    }

    protected function getAlias()
    {
        return 'b';
    }
}
