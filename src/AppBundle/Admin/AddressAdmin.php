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
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use AppBundle\Entity\Address;

class AddressAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->parentAssociationMapping = 'business';
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with($this->trans('address.form.group_advanced_label', array(), 'SonataCustomerBundle'))
            ->add('type', 'choice', array('choices' => Address::getTypesList(), 'translation_domain' => 'SonataCustomerBundle'))
            ->add('current', null, array('required' => false))
            ->add('name')
            ->end();

        $formMapper
            ->with($this->trans('address.form.group_contact_label', array(), 'SonataCustomerBundle'))
            ->add('firstname')
            ->add('lastname')
            ->add('phone')
            ->end()
        ;

        if (!$this->isChild()) {
            $formMapper->with($this->trans('address.form.group_contact_label', array(), 'SonataCustomerBundle'))
                ->add('business', 'sonata_type_model_list')
                ->end()
            ;
        }

        $formMapper
            ->with($this->trans('address.form.group_address_label', array(), 'SonataCustomerBundle'))
            ->add('address1')
            ->add('address2')
            ->add('address3')
            ->add('postcode')
            ->add('city')
            ->add('countryCode', 'country')
            ->end()
        ;
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $list
     */
    public function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('fulladdress', 'string', array('code' => 'getFullAddressHtml', 'template' => 'SonataCustomerBundle:Admin:list_address.html.twig'))
            ->add('current')
            ->add('typeCode', 'trans', array('catalogue' => $this->translationDomain))
        ;
    }
}
