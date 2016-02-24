<?php

namespace Buseta\BodegaBundle\EventListener;

use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\BitacoraSerial\BitacoraSerialInventarioFisicoEvent;
use Buseta\BodegaBundle\Event\FilterInventarioFisicoEvent;
use Buseta\BodegaBundle\Event\InventarioFisicoEvents;
use Buseta\BodegaBundle\Manager\InventarioFisicoManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InventarioFisicoSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\BodegaBundle\Manager\InventarioFisicoManager
     */
    private $inventariofisicoManager;


    /**
     * @param \Buseta\BodegaBundle\Manager\InventarioFisicoManager $inventariofisicoManager
     */
    function __construct(InventarioFisicoManager $inventariofisicoManager)
    {
        $this->inventariofisicoManager  = $inventariofisicoManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_CREATE => 'preCreate',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_CREATE => 'postCreate',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_PROCESS => 'preProcess',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_PROCESS => 'postProcess',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_COMPLETE => 'preComplete',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_COMPLETE => 'postComplete',
        );
    }

    public function preCreate(BitacoraSerialInventarioFisicoEvent $serialInventarioFisicoEvent)
    {

    }

    public function postCreate(BitacoraSerialInventarioFisicoEvent $serialInventarioFisicoEvent)
    {

    }

    public function preProcess(BitacoraSerialInventarioFisicoEvent $serialInventarioFisicoEvent)
    {

    }

    public function postProcess(BitacoraSerialInventarioFisicoEvent $serialInventarioFisicoEvent)
    {

    }

    public function preComplete(BitacoraSerialInventarioFisicoEvent $serialInventarioFisicoEvent)
    {

    }

    public function postComplete(BitacoraSerialInventarioFisicoEvent $serialInventarioFisicoEvent)
    {

    }
}
