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

class UserAdmin extends Admin
{

    protected $baseRoutePattern = 'user';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('General');

        $formMapper
            ->add('username')
            ->add('roles' ,'choice' ,array('choices' => $this->getRolesNames(),
                'required'  => true,
                'expanded' => true,
                'mapped' => true,
                'multiple' => true
            ))
            ->add('plainPassword', 'text', ['required' => false])
            ->end();

    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username', null);
    }

    public function getRolesNames(){
        return [
            "ROLE_EMPLOYEE" => "Employee",
            "ROLE_MANAGER" => "Manager",
        ];
    }
}
