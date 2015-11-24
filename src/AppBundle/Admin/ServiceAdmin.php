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
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints as Assert;

class ServiceAdmin extends Admin
{

    protected $baseRoutePattern = 'service';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('General');

        if (!$this->hasParentFieldDescription()) {

            $formMapper->add('business', 'sonata_type_model_autocomplete', ['constraints' => new Assert\NotNull(), 'property'=>'firstname', 'placeholder' => 'Enter the business name']);
        }

        $formMapper
            ->add('type')
            ->add('duration')
            ->add('price')
            ->add('description')
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('type')
            ->add('duration')
            ->add('price')
            ->add('description');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null)
            ->add('type')
            ->add('duration')
            ->add('price')
            ->add('description');
    }
}
