<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type\Api;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;

class PersonalizedServiceType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duration')
            ->add('price')
            ->add('cusomer', 'entity', [
                'class' => 'AppBundle:Customer',
            ])
            ->add('service', 'entity', [
                'class' => 'AppBundle:Service',
            ])
        ;
    }

    public function getName()
    {
        return 'app_api_personalized_service';
    }
}
