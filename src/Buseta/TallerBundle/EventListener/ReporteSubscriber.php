<?php

namespace Buseta\TallerBundle\EventListener;

use Buseta\TallerBundle\Event\FilterReporteEvent;
use Buseta\TallerBundle\Event\ReporteEvents;
use Buseta\TallerBundle\Manager\ReporteManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReporteSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\TallerBundle\Manager\ReporteManager
     */
    private $reporteManager;


    /**
     * @param \Buseta\TallerBundle\Manager\ReporteManager $reporteManager
     */
    function __construct(ReporteManager $reporteManager)
    {
        $this->reporteManager = $reporteManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            ReporteEvents::PROCESAR_SOLICITUD         => 'crearDiagnostico',
            ReporteEvents::CAMBIAR_ESTADO_ABIERTO     => 'cambioEstadoDiagnosticoAbierto',
            ReporteEvents::CAMBIAR_ESTADO_PENDIENTE   => 'cambioEstadoDiagnosticoPendiente',
            ReporteEvents::CAMBIAR_ESTADO_COMPLETADO  => 'cambioEstadoDiagnosticoCompletado',
        );
    }

    //Llamada a los Eventos
    public function cambioEstadoDiagnosticoAbierto(FilterReporteEvent $event)
    {
        $this->cambioEstado($event, 'BO');
    }

    public function cambioEstadoDiagnosticoPendiente(FilterReporteEvent $event)
    {
        $this->cambioEstado($event,'PR' );
    }

    public function cambioEstadoDiagnosticoCompletado(FilterReporteEvent $event)
    {
        $this->cambioEstado($event, 'CO');
    }

    //Llamo al Manager para Cambiar Estado
    public function cambioEstado(FilterReporteEvent $event, $estado)
    {
        $reporte = $event->getReporte();
        $this->reporteManager->cambiarEstado($reporte,$estado);
    }

    //Llamo al Manager para Crear Diagnostico
    public function crearDiagnostico(FilterReporteEvent $event)
    {
        $reporte = $event->getReporte();

        $this->reporteManager->crearDiagnostico($reporte);
    }

}