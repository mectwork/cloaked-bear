<?php

namespace Buseta\BodegaBundle\Doctrine;


use Buseta\BodegaBundle\Interfaces\DateTimeAwareInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Common\EventSubscriber;

/**
 * Class DateTimeSubscriber
 * @package Buseta\BodegaBundle\Doctrine
 */
class DateTimeSubscriber implements EventSubscriber
{
    /**
     * @inheritdoc
     */
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
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof DateTimeAwareInterface) {
            $object->setCreated(new \DateTime());
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof DateTimeAwareInterface) {
            $object->setUpdated(new \DateTime());
        }
    }
}
