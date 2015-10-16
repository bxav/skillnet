<?php
namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Knp\Menu\ItemInterface as MenuItemInterface;

class BusinessAdmin extends Admin
{

    protected $baseRoutePattern = 'business';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
            ->add('name')
            ->add('phone')
            ->add('website')
            ->add('address')
            ->add('description')
            ->add('disponibilityTimeSlot', 'integer')
            ->end()
            ->with('Image', ['class' => 'col-md-12'])
            ->add('image', 'image', [
                'by_reference' => false,
                'cascade_validation' => true
            ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            )
            ->end()
            ->with('Employees', ['class' => 'col-md-12'])
            ->add('employees', 'sonata_type_collection', [
                'by_reference' => false,
                'cascade_validation' => true
            ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            )
            ->end()
            ->with('Services', ['class' => 'col-md-12'])
            ->add('services', 'sonata_type_collection', [
                'by_reference' => false,
                'cascade_validation' => true
            ],
                [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]
            )
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('phone')
            ->add('website');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null)
            ->add('website')
            ->add('phone');

    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }
        $admin = $this->isChild() ? $this->getParent() : $this;
        $id = $admin->getRequest()->get('id');
        $menu->addChild(
            'Edit business',
            $admin->generateMenuUrl('edit', array('id' => $id))
        );
        $menu->addChild(
            'Address list',
            $admin->generateMenuUrl('sonata.admin.address.list', array('id' => $id))
        );
    }
}
