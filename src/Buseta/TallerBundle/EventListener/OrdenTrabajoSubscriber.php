<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/12/15
 * Time: 22:12
 */


namespace Buseta\TallerBundle\EventListener;

use Buseta\TallerBundle\Event\FilterOrdenTrabajoEvent;
use Buseta\TallerBundle\Event\OrdenTrabajoEvents;
use Buseta\TallerBundle\Manager\OrdenTrabajoManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrdenTrabajoSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\TallerBundle\Manager\OrdenTrabajoManager
     */
    private $ordenTrabajoManager;


    /**
     * @param \Buseta\TallerBundle\Manager\OrdenTrabajoManager $ordenTrabajoManager
     */
    function __construct(OrdenTrabajoManager $ordenTrabajoManager)
    {
        $this->ordenTrabajoManager = $ordenTrabajoManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
//            OrdenTrabajoEvents::PROCESAR_ORDEN         => 'crearSolicitudCompletada',
            OrdenTrabajoEvents::CAMBIAR_ESTADO_ABIERTO => 'cambioEstadoOrdenAbierto',
            OrdenTrabajoEvents::CAMBIAR_CANCELADO   => 'cambiarCancelado',
            OrdenTrabajoEvents::CAMBIAR_ESTADO_CERRADO   => 'cambioEstadoOrdenCerrado',
            OrdenTrabajoEvents::CAMBIAR_ESTADO_COMPLETADO  => 'cambioEstadoOrdenCompletado',
        );
    }



    public function cambiarCancelado(FilterOrdenTrabajoEvent $event)
    {
        $orden = $event->getOrden();
        $this->ordenTrabajoManager->cambiarCancelado($orden);
    }

    public function cambioEstadoOrdenCerrado(FilterOrdenTrabajoEvent $event)
    {
        $this->cambioEstado($event, 'CO' );
    }

    public function cambioEstadoOrdenAbierto(FilterOrdenTrabajoEvent $event)
    {
        $this->cambioEstado($event, 'BO' );
    }

    public function cambioEstadoOrdenCompletado(FilterOrdenTrabajoEvent $event)
    {
        $this->cambioEstado($event, 'CO');
    }

    public function cambioEstado(FilterOrdenTrabajoEvent $event, $estado)
    {
        $orden = $event->getOrden();
        $this->ordenTrabajoManager->cambiarEstado($orden, $estado);
    }

//    public function crearSolicitudCompletada(FilterOrdenTrabajoEvent $event)
//    {
//        $orden = $event->getOrden();
//
//        $this->ordenTrabajoManager->crearSolicitudCompletada($orden);
//
//    }

}
