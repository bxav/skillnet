<?php

namespace AppBundle\Form\Type\Api;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;

class ServiceType extends AbstractResourceType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duration')
            ->add('type')
            ->add('price')
            ->add('description')
            ->add('business', 'entity', [
                'class' => 'AppBundle:Business'
            ])
        ;
    }

    public function getName()
    {
        return 'app_api_service';
    }
}