<?php

namespace AppBundle\Entity;

use Pagerfanta\PagerfantaInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class ServiceRepository extends EntityRepository
{

    /**
     * Create employee services paginator.
     *
     * @param Employee $employee
     * @param array         $sorting
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

    protected function getAlias()
    {
        return 's';
    }
}
