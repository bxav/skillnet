<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Image;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\RequestStack;

class SetRealPathFile
{

    protected $host;

    public function __construct(RequestStack $request_stack)
    {
        $request = $request_stack->getCurrentRequest();
        $this->host = $request ? $request->getHttpHost() : null;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Image) {
            //todo extract hosting path

            $entity->setHost($this->host . '/media/image');
        }
    }
}