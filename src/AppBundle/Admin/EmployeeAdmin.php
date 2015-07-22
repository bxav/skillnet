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

class EmployeeAdmin extends Admin
{

    protected $baseRoutePattern = 'employee';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('General');

        if (!$this->hasParentFieldDescription()) {
            $formMapper->add('business', 'sonata_type_model_autocomplete', ['constraints' => new Assert\NotNull(), 'property'=>'name', 'placeholder' => 'Enter the business name']);
        }

        $formMapper
            ->add('firstname')
            ->add('shortDescription')
            ->add('speciality')
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstname')
            ->add('shortDescription')
            ->add('speciality');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('firstname', null)
            ->add('shortDescription')
            ->add('speciality');
    }
}