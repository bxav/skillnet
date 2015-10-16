<?php

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