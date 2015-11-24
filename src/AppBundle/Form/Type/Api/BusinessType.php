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

class BusinessType extends AbstractResourceType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('website')
            ->add('phone')
            ->add('email')
            ->add('description')
            ->add('disponibilityTimeSlot')
        ;
    }

    public function getName()
    {
        return 'app_api_business';
    }
}