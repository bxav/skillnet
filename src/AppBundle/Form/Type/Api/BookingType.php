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

class BookingType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDatetime', 'datetime', [
                'widget' => 'single_text',
            ])
            ->add('endDatetime', 'datetime', [
                'widget' => 'single_text',
            ])
            ->add('service', 'entity', [
                'class' => 'AppBundle:Service',
            ])
            ->add('customer', 'entity', [
                'class' => 'AppBundle:Customer',
            ])
            ->add('employee', 'entity', [
                'class' => 'AppBundle:Employee',
            ])
        ;
    }

    public function getName()
    {
        return 'app_api_booking';
    }
}
