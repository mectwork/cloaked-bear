<?php

namespace Buseta\BodegaBundle\EventListener;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraMovimientoEvent;
use Buseta\BodegaBundle\Event\FilterMovimientoEvent;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class MovimientoSubscriber
 *
 * @package Buseta\BodegaBundle\EventListener
 */
class MovimientoSubscriber implements EventSubscriberInterface
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
            //BusetaBodegaEvents::MOVEMENT_PRE_CREATE  => 'undefinedEvent',
            //BusetaBodegaEvents::MOVEMENT_POST_CREATE  => 'undefinedEvent',
            BusetaBodegaEvents::MOVEMENT_PRE_PROCESS => 'preProcess',
            //BusetaBodegaEvents::MOVEMENT_PROCESS  => 'undefinedEvent',
            BusetaBodegaEvents::MOVEMENT_POST_PROCESS => 'postProcess',
            BusetaBodegaEvents::MOVEMENT_PRE_COMPLETE => 'preComplete',
            //BusetaBodegaEvents::MOVEMENT_COMPLETE => 'undefinedEvent',
            BusetaBodegaEvents::MOVEMENT_POST_COMPLETE => 'postComplete',
        );
    }

    /**
     * @param FilterMovimientoEvent $event
     *
     * @throws NotValidStateException
     */
    public function preProcess(FilterMovimientoEvent $event)
    {
        $movimiento = $event->getMovimiento();
        if ($movimiento->getEstadoDocumento() !== BusetaBodegaDocumentStatus::DOCUMENT_STATUS_DRAFT) {
            throw new NotValidStateException();
        }
    }

    /**
     * @param FilterMovimientoEvent $event
     */
    public function postProcess(FilterMovimientoEvent $event)
    {

    }

    /**
     * @param FilterMovimientoEvent $event
     *
     * @throws NotValidStateException
     */
    public function preComplete(FilterMovimientoEvent $event)
    {
        $movimiento = $event->getMovimiento();
        if ($movimiento->getEstadoDocumento() !== BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS) {
            throw new NotValidStateException();
        }
    }

    /**
     * @param FilterMovimientoEvent $event
     * @param string|null $eventName
     * @param EventDispatcherInterface|null $eventDispatcher
     */
    public function postComplete(
        FilterMovimientoEvent $event,
        $eventName = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $bitacoraEvent = new BitacoraMovimientoEvent($event->getMovimiento());
        $eventDispatcher->dispatch(BusetaBodegaEvents::BITACORA_MOVEMENT_FROM_TO, $bitacoraEvent);

        if ($error = $bitacoraEvent->getError()) {
            $event->setError($error);
        }
    }
}
