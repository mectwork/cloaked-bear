<?php

namespace Buseta\BodegaBundle\EventListener;


use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraSalidaBodegaEvent;
use Buseta\BodegaBundle\Event\FilterSalidaBodegaEvent;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class SalidaBodegaSubscriber
 *
 * @package Buseta\BodegaBundle\EventListener
 */
class SalidaBodegaSubscriber implements EventSubscriberInterface
{
    /**
     * @var Logger
     */
    private $logger;


    /**
     * AlbaranSubscriber Constructor
     *
     * @param Logger            $logger
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
            //BusetaBodegaEvents::WAREHOUSE_INOUT_PRE_CREATE  => 'undefinedEvent',
            //BusetaBodegaEvents::WAREHOUSE_INOUT_POST_CREATE  => 'undefinedEvent',
            BusetaBodegaEvents::WAREHOUSE_INOUT_PRE_PROCESS  => 'preProcess',
            //BusetaBodegaEvents::WAREHOUSE_INOUT_PROCESS  => 'undefinedEvent',
            BusetaBodegaEvents::WAREHOUSE_INOUT_POST_PROCESS  => 'postProcess',
            BusetaBodegaEvents::WAREHOUSE_INOUT_PRE_COMPLETE => 'preComplete',
            //BusetaBodegaEvents::WAREHOUSE_INOUT_COMPLETE => 'undefinedEvent',
            BusetaBodegaEvents::WAREHOUSE_INOUT_POST_COMPLETE => 'postComplete',
        );
    }

    /**
     * @param FilterSalidaBodegaEvent $event
     *
     * @throws NotValidStateException
     */
    public function preProcess(FilterSalidaBodegaEvent $event)
    {
        $salidaBodega = $event->getSalidaBodega();
        if ($salidaBodega->getEstadoDocumento() !== BusetaBodegaDocumentStatus::DOCUMENT_STATUS_DRAFT) {
            $this->logger->error(
                sprintf(
                    'El estado %s de Salida Bodega con id %d no se corresponde con el estado previo a procesado.',
                    $salidaBodega->getEstadoDocumento(),
                    $salidaBodega->getId()
                )
            );

            throw new NotValidStateException();
        }
    }

    /**
     * @param FilterSalidaBodegaEvent $event
     */
    public function postProcess(FilterSalidaBodegaEvent $event)
    {

    }

    /**
     * @param FilterSalidaBodegaEvent $event
     *
     * @throws NotValidStateException
     */
    public function preComplete(FilterSalidaBodegaEvent $event)
    {
        $salidaBodega = $event->getSalidaBodega();
        if ($salidaBodega->getEstadoDocumento() !== BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS) {
            $this->logger->error(
                sprintf(
                    'El estado %s de Salida Bodega con id %d no se corresponde con el estado previo a completado.',
                    $salidaBodega->getEstadoDocumento(),
                    $salidaBodega->getId()
                )
            );

            throw new NotValidStateException();
        }
    }

    /**
     * @param FilterSalidaBodegaEvent            $event
     * @param string|null                   $eventName
     * @param EventDispatcherInterface|null $eventDispatcher
     */
    public function postComplete(
        FilterSalidaBodegaEvent $event,
        $eventName = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $bitacoraEvent = new BitacoraSalidaBodegaEvent($event->getSalidaBodega());
        $eventDispatcher->dispatch(BusetaBodegaEvents::BITACORA_INTERNAL_CONSUMPTION, $bitacoraEvent);

        if ($error = $bitacoraEvent->getError()) {
            $event->setError($error);
        }
    }
}
