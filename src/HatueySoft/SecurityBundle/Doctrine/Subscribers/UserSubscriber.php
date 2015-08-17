<?php

namespace HatueySoft\SecurityBundle\Doctrine\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use BusBPM\CoreBundle\Entity\UserAwareInterface;

class UserSubscriber implements EventSubscriber
{
    protected $userCallable;

    public function __construct(callable $userCallable)
    {
        $this->userCallable = $userCallable;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof UserAwareInterface) {
            $user = $this->getLoggedUser();
            $object->setCreatedBy($user);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof UserAwareInterface) {
            $user = $this->getLoggedUser();
            $object->setUpdatedBy($user);
        }
    }

    private function getLoggedUser()
    {
        $callable = $this->userCallable;
        $user = $callable();

        return $user;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
        );
    }
}
