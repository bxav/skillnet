<?php

namespace AppBundle\Doctrine;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Employee;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Model\UserInterface;

abstract class AbstractUserListener implements EventSubscriber
{

    private $userManager;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Pre persist listener based on doctrine commons, overwrite for drivers
     * that are not compatible with the commons events.
     *
     * @param LifecycleEventArgs $args weak typed to allow overwriting
     */
    public function prePersist($args)
    {
        $object = $args->getObject();
        if ($object instanceof UserInterface) {
            $this->updateUserFields($object);
        }
    }

    /**
     * Pre update listener based on doctrine commons, overwrite to update
     * the changeset in the UoW and to handle non-common event argument
     * class.
     *
     * @param LifecycleEventArgs $args weak typed to allow overwriting
     */
    public function preUpdate($args)
    {
        $object = $args->getObject();
        if ($object instanceof UserInterface) {
            $this->updateUserFields($object);
        }
    }

    /**
     * This must be called on prePersist and preUpdate if the event is about a
     * user.
     *
     * @param UserInterface $user
     */
    protected function updateUserFields(UserInterface $user)
    {
        if (null === $this->userManager) {
            if ($user instanceof Employee) {
                $this->userManager = $this->container->get('app.user.user_manager.employee');
            } elseif ($user instanceof Customer) {
                $this->userManager = $this->container->get('app.user.user_manager.customer');
            }
        }

        $this->userManager->updatePassword($user);
    }
}
