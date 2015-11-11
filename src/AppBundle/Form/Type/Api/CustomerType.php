<?php

namespace AppBundle\Form\Type\Api;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerType extends AbstractResourceType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('user', 'entity', [
                'class' => 'AppBundle:User'
            ])
        ;
    }

    public function getName()
    {
        return 'app_api_customer';
    }
}