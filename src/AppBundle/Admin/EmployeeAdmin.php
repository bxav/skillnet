<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Validator\Constraints as Assert;

class EmployeeAdmin extends Admin
{
    protected $baseRoutePattern = 'employee';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General');

        if (!$this->hasParentFieldDescription()) {
            $formMapper->add('business', 'sonata_type_model_autocomplete', [
                'constraints' => new Assert\NotNull(),
                'property' => 'name',
                'placeholder' => 'Enter the business name',
            ]);
        }

        $formMapper
            ->add('firstname')
            ->add('lastname')
            ->add('shortDescription')
            ->add('speciality')
            ->end();

        if (!$this->hasParentFieldDescription()) {
            $em = $this->modelManager->getEntityManager('AppBundle\Entity\Service');

            $query = $em->createQueryBuilder('s')
                ->select('s')
                ->from('AppBundle:Service', 's')
                ->where('s.business = :business')
                ->setParameter('business', $this->getSubject()->getBusiness());

            $formMapper
                ->with('Services', ['class' => 'col-md-12'])
                ->add('services', 'sonata_type_model', [
                    'property' => 'type',
                    'multiple' => true,
                    'by_reference' => false,
                    'btn_add' => false,
                    'query' => $query,
                    'required' => false,
                ])
                ->end();
        }
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstname')
            ->add('lastname')
            ->add('shortDescription')
            ->add('speciality');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null)
            ->add('firstname')
            ->add('lastname')
            ->add('shortDescription')
            ->add('speciality');
    }

    public function getRolesNames()
    {
        return [
            'ROLE_EMPLOYEE' => 'Employee',
            'ROLE_MANAGER' => 'Manager',
        ];
    }
}
