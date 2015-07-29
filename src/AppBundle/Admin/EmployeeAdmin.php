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
                ->add('services', 'sonata_type_model', array('multiple' => true, 'by_reference' => false, 'btn_add' => false, 'query' => $query))
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
            ->addIdentifier('firstname', null)
            ->add('lastname')
            ->add('shortDescription')
            ->add('speciality');
    }
}