<?php

namespace Buseta\BodegaBundle\EventListener;


use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraAlbaranEvent;
use Buseta\BodegaBundle\Event\FilterAlbaranEvent;
use Buseta\BodegaBundle\Manager\AlbaranManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AlbaranSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\BodegaBundle\Manager\AlbaranManager
     */
    private $albaranManager;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher = null;


    /**
     * @param \Buseta\BodegaBundle\Manager\AlbaranManager $albaranManager
     */
    function __construct(AlbaranManager $albaranManager)
    {
        $this->albaranManager  = $albaranManager;
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
            //BusetaBodegaEvents::ALBARAN_POST_PROCESS  => 'undefinedEvent',
            //BusetaBodegaEvents::ALBARAN_PRE_COMPLETE => 'undefinedEvent',
            //BusetaBodegaEvents::ALBARAN_COMPLETE => 'undefinedEvent',
            BusetaBodegaEvents::ALBARAN_POST_COMPLETE => 'posComplete',
        );
    }

    public function preProcess(FilterAlbaranEvent $event)
    {
        // trigger validation
    }

    public function posComplete(FilterAlbaranEvent $event, $eventName = null, EventDispatcherInterface $eventDispatcher = null)
    {
        $bitacoraEvent = new BitacoraAlbaranEvent($event->getAlbaran(), $event->isFlush());
        $eventDispatcher->dispatch(BusetaBodegaEvents::BITACORA_VENDOR_RECEIPTS, $bitacoraEvent);

        if (null !== $error = $bitacoraEvent->getError()) {
            $event->setError($error);
        }
    }

    public function cambiarestadoProcesado(FilterAlbaranEvent $event)
    {
        $this->cambiarEstado($event, 'PR');
    }

    public function cambiarestadoCompletado(FilterAlbaranEvent $event)
    {
        $this->cambiarEstado($event, 'CO');
    }

    private function cambiarEstado(FilterAlbaranEvent $event, $estado )
    {
        $albaran = $event->getEntityData();
        //Si hay error devuelve el string del error, si todo ok devuelve true
        $result=  $this->albaranManager->legacyCambiarestado( $albaran , $estado );
        $event->setReturnValue( $result );
    }

    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->dispatcher = $eventDispatcher;
    }
}
