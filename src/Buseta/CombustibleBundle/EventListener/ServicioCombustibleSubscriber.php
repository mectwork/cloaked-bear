<?php

namespace Buseta\CombustibleBundle\EventListener;


use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\CombustibleBundle\BusetaCombustibleEvents;
use Buseta\CombustibleBundle\Event\BitacoraBodega\BitacoraServicioCombustibleEvent;
use Buseta\CombustibleBundle\Event\FilterServicioCombustibleEvent;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ServicioCombustibleSubscriber implements EventSubscriberInterface
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
            //BusetaCombustibleEvents::SERVICIO_COMBUSTIBLE_PRE_CREATE  => 'preCreate',
            BusetaCombustibleEvents::SERVICIO_COMBUSTIBLE_POST_CREATE => 'postCreate',
        );
    }

    public function preCreate(FilterServicioCombustibleEvent $event)
    {

    }

    public function postCreate(
        FilterServicioCombustibleEvent $event,
        $eventName=null,
        EventDispatcherInterface $dispatcher=null
    ) {
        $servicioCombustible = $event->getServicioCombustible();
        $confCombustible = $event->getConfCombustible();
        $confMarchamo = $event->getConfMarchamo();
        $bitacoraEvent = new BitacoraServicioCombustibleEvent($servicioCombustible, $confCombustible, $confMarchamo);
        $dispatcher->dispatch(BusetaBodegaEvents::BITACORA_INTERNAL_CONSUMPTION, $bitacoraEvent);

        if ($bitacoraEvent->getError()) {
            $event->setError($bitacoraEvent->getError());
        }
    }
}
