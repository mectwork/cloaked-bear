<?php

namespace Buseta\BodegaBundle\EventListener;


use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraAlbaranEvent;
use Buseta\BodegaBundle\Event\FilterAlbaranEvent;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Buseta\BodegaBundle\Manager\AlbaranManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AlbaranSubscriber implements EventSubscriberInterface
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
            //BusetaBodegaEvents::ALBARAN_PRE_CREATE  => 'undefinedEvent',
            //BusetaBodegaEvents::ALBARAN_POST_CREATE  => 'undefinedEvent',
            BusetaBodegaEvents::ALBARAN_PRE_PROCESS  => 'preProcess',
            //BusetaBodegaEvents::ALBARAN_PROCESS  => 'undefinedEvent',
            BusetaBodegaEvents::ALBARAN_POST_PROCESS  => 'postProcess',
            BusetaBodegaEvents::ALBARAN_PRE_COMPLETE => 'preComplete',
            //BusetaBodegaEvents::ALBARAN_COMPLETE => 'undefinedEvent',
            BusetaBodegaEvents::ALBARAN_POST_COMPLETE => 'postComplete',
        );
    }

    /**
     * @param FilterAlbaranEvent $event
     *
     * @throws NotValidStateException
     */
    public function preProcess(FilterAlbaranEvent $event)
    {
        $albaran = $event->getAlbaran();
        if ($albaran->getEstadoDocumento() !== 'BO') {
            $this->logger->error(
                sprintf(
                    'El estado %s del Albaran con id %d no se corresponde con el estado previo a procesado(PR).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                )
            );

            throw new NotValidStateException();
        }
    }

    /**
     * @param FilterAlbaranEvent $event
     */
    public function postProcess(FilterAlbaranEvent $event)
    {

    }

    /**
     * @param FilterAlbaranEvent $event
     */
    public function preComplete(FilterAlbaranEvent $event)
    {

    }

    /**
     * @param FilterAlbaranEvent            $event
     * @param string|null                          $eventName
     * @param EventDispatcherInterface|null $eventDispatcher
     */
    public function postComplete(FilterAlbaranEvent $event, $eventName = null, EventDispatcherInterface $eventDispatcher = null)
    {
        $bitacoraEvent = new BitacoraAlbaranEvent($event->getAlbaran(), $event->isFlush());
        $eventDispatcher->dispatch(BusetaBodegaEvents::BITACORA_VENDOR_RECEIPTS, $bitacoraEvent);

        if (null !== $error = $bitacoraEvent->getError()) {
            $event->setError($error);
        }
    }
}
