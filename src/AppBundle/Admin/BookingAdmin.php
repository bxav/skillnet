<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints as Assert;

class BookingAdmin extends Admin
{

    protected $baseRoutePattern = 'booking';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('startDatetime', 'sonata_type_datetime_picker')
            ->add('endDatetime','sonata_type_datetime_picker')
            ->add('customer', 'sonata_type_model_autocomplete', [
                'constraints' => new Assert\NotNull(),
                'property'=>'username',
                'placeholder' => 'Enter the customer username'
            ])
            ->add('employee')
            ->add('service')
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('startDatetime')
            ->add('endDatetime')
            ->add('customer.username')
            ->add('employee')
            ->add('service');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null)
            ->add('startDatetime')
            ->add('endDatetime')
            ->add('customer.username')
            ->add('employee')
            ->add('service');

    }
}