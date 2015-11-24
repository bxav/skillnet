<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BxMarket\User\Doctrine\Orm;

use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use BxMarket\User\Model\UserInterface;
use BxMarket\User\Doctrine\AbstractUserListener;

/**
 * Doctrine ORM listener updating the canonical fields and the password.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class UserListener extends AbstractUserListener
{
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist($args)
    {
        $object = $args->getEntity();
        if ($object instanceof UserInterface) {
            $this->updateUserFields($object);
        }
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate($args)
    {
        $object = $args->getEntity();
        if ($object instanceof UserInterface) {
            $this->updateUserFields($object);
            // We are doing a update, so we must force Doctrine to update the
            // changeset in case we changed something above
            $em   = $args->getEntityManager();
            $uow  = $em->getUnitOfWork();
            $meta = $em->getClassMetadata(get_class($object));
            $uow->recomputeSingleEntityChangeSet($meta, $object);
        }
    }
}
