<?php

namespace Buseta\BodegaBundle\EventListener;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraInventarioFisicoEvent;
use Buseta\BodegaBundle\Event\FilterInventarioFisicoEvent;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InventarioFisicoSubscriber implements EventSubscriberInterface
{
    /**
     * @var Logger
     */
    private $logger;


    /**
     * AlbaranSubscriber Constructor
     *
     * @param Logger $logger
     */
    function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            //BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_CREATE => 'preCreate',
            //BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_CREATE => 'postCreate',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_PROCESS => 'preProcess',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_PROCESS => 'postProcess',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_COMPLETE => 'preComplete',
            BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_COMPLETE => 'postComplete',
        );
    }

//    public function preCreate(FilterInventarioFisicoEvent $event)
//    {
//
//    }
//
//    public function postCreate(FilterInventarioFisicoEvent $event)
//    {
//
//    }

    /**
     * @param FilterInventarioFisicoEvent $event
     *
     * @throws NotValidStateException
     */
    public function preProcess(FilterInventarioFisicoEvent $event)
    {
        $inventarioFisico = $event->getInventarioFisico();
        if ($inventarioFisico->getEstado() !== BusetaBodegaDocumentStatus::DOCUMENT_STATUS_DRAFT) {
            throw new NotValidStateException();
        }
    }

    /**
     * @param FilterInventarioFisicoEvent $event
     */
    public function postProcess(FilterInventarioFisicoEvent $event)
    {

    }

    /**
     * @param FilterInventarioFisicoEvent $event
     *
     * @throws NotValidStateException
     */
    public function preComplete(FilterInventarioFisicoEvent $event)
    {
        $inventarioFisico = $event->getInventarioFisico();
        if ($inventarioFisico->getEstado() !== BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS) {
            throw new NotValidStateException();
        }
    }

    /**
     * @param FilterInventarioFisicoEvent   $event
     * @param null                          $eventName
     * @param EventDispatcherInterface|null $eventDispatcher
     */
    public function postComplete(
        FilterInventarioFisicoEvent $event,
        $eventName = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $bitacoraEvent = new BitacoraInventarioFisicoEvent($event->getInventarioFisico());
        $eventDispatcher->dispatch(BusetaBodegaEvents::BITACORA_INVENTORY_IN_OUT, $bitacoraEvent);

        if ($error = $bitacoraEvent->getError()) {
            $event->setError($error);
        }
    }
}
