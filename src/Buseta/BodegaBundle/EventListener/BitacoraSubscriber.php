<?php

namespace Buseta\BodegaBundle\EventListener;


use Buseta\BodegaBundle\BusetaBodegaBitacoraEvents;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Buseta\BodegaBundle\Manager\BitacoraAlmacenManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BitacoraSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\BodegaBundle\Manager\BitacoraAlmacenManager
     */
    private $bitacoraManager;


    /**
     * @param \Buseta\BodegaBundle\Manager\BitacoraAlmacenManager $bitacoraManager
     */
    function __construct(BitacoraAlmacenManager $bitacoraManager)
    {
        $this->bitacoraManager  = $bitacoraManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            BusetaBodegaBitacoraEvents::CUSTOMER_RETURNS                => 'customerReturns',
            BusetaBodegaBitacoraEvents::CUSTOMER_SHIPMENT               => 'customerShipment',
            BusetaBodegaBitacoraEvents::INTERNAL_CONSUMPTION_POSITIVE   => 'internalConsumptionPositive',
            BusetaBodegaBitacoraEvents::INTERNAL_CONSUMPTION_NEGATIVE   => 'internalConsumptionNegative',
            BusetaBodegaBitacoraEvents::INVENTORY_IN                    => 'inventoryIn',
            BusetaBodegaBitacoraEvents::INVENTORY_OUT                   => 'inventoryOut',
            BusetaBodegaBitacoraEvents::MOVEMENT_TO                     => 'movementTo',
            BusetaBodegaBitacoraEvents::MOVEMENT_FROM                   => 'movementFrom',
            BusetaBodegaBitacoraEvents::PRODUCTION_POSITIVE             => 'productionPositive',
            BusetaBodegaBitacoraEvents::PRODUCTION_NEGATIVE             => 'productionNegative',
            BusetaBodegaBitacoraEvents::VENDOR_RECEIPTS                 => 'vendorReceipts',
            BusetaBodegaBitacoraEvents::VENDOR_RETURNS                  => 'vendorReturns',
            BusetaBodegaBitacoraEvents::WORK_ORDER_POSITIVE             => 'workOrderPositive',
            BusetaBodegaBitacoraEvents::WORK_ORDER_NEGATIVE             => 'workOrderNegative',
        );
    }

    public function customerReturns(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'C+');
    }

    public function customerShipment(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'C-');
    }

    public function internalConsumptionPositive(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'D+');
    }

    public function internalConsumptionNegative(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'D-');
    }

    public function inventoryIn(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'I+');
    }

    public function inventoryOut(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'I-');
    }

    public function movementTo(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'M+');
    }

    public function movementFrom(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'M-');
    }

    public function productionPositive(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'P+');
    }

    public function productionNegative(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'P-');
    }

    public function vendorReceipts(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'V+');
    }

    public function vendorReturns(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'V-');
    }

    public function workOrderPositive(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'W+');
    }

    public function workOrderNegative(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'W-');
    }

    public function createRegistry(FilterBitacoraEvent $event, $movementType)
    {
        $bitacora = $event->getEntityData();
        $bitacora->setTipoMovimiento($movementType);

        $this->bitacoraManager->createRegistry($bitacora);
    }
}
