<?php

namespace AppBundle\Form\Type\Api;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;

class EmployeeType extends AbstractResourceType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('speciality')
            ->add('shortDescription')
            ->add('business', 'entity', [
                'class' => 'AppBundle:Business'
            ])
            ->add('user', 'entity', [
                'class' => 'AppBundle:User'
            ])
        ;
    }

    public function getName()
    {
        return 'app_api_employee';
    }
}