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

class ServiceRepository extends EntityRepository
{
    /**
     * Create employee services paginator.
     *
     * @param Employee $employee
     * @param array    $sorting
     *
     * @return PagerfantaInterface
     */
    public function createByEmployeePaginator($employee, $sorting = array())
    {
        $sorting = $sorting ? $sorting : [];
        $queryBuilder = $this->getCollectionQueryBuilderByEmployee($employee, $sorting);

        return $this->getPaginator($queryBuilder);
    }

    protected function getCollectionQueryBuilderByEmployee($employee, array $sorting = array())
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder
            ->leftJoin(
                's.employees', 'e', \Doctrine\ORM\Query\Expr\Join::WITH, 'e = :employee'
            )
            ->setParameter('employee', $employee)
        ;
        $this->applySorting($queryBuilder, $sorting);

        return $queryBuilder;
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

        if (!empty($criteria['business'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('s.business', ':business'))
                ->setParameter('business', $criteria['business'])
            ;
        }

        return $this->getPaginator($queryBuilder);
    }

    protected function getAlias()
    {
        return 's';
    }
}
