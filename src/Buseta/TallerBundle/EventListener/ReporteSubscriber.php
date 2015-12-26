<?php

namespace Buseta\TallerBundle\EventListener;

use Buseta\TallerBundle\Event\FilterReporteEvent;
use Buseta\TallerBundle\Event\ReporteEvents;
use Buseta\TallerBundle\Manager\DiagnosticoManager;
use Buseta\TallerBundle\Manager\ReporteManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReporteSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\TallerBundle\Manager\ReporteManager
     */
    private $reporteManager;

    /**
     * @var \Buseta\TallerBundle\Manager\DiagnosticoManager
     */
    private $diagnosticoManager;


    /**
     * @param \Buseta\TallerBundle\Manager\ReporteManager $reporteManager
     * @param \Buseta\TallerBundle\Manager\DiagnosticoManager $diagnosticoManager
     */
    function __construct(ReporteManager $reporteManager, DiagnosticoManager $diagnosticoManager)
    {
        $this->reporteManager = $reporteManager;
        $this->diagnosticoManager = $diagnosticoManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            ReporteEvents::PROCESAR_SOLICITUD         => 'crearDiagnostico',
            ReporteEvents::CAMBIAR_ESTADO_PENDIENTE   => 'cambioEstadoReportePendiente',
            ReporteEvents::CAMBIAR_ESTADO_COMPLETADO  => 'cambioEstadoReporteCompletado',
        );
    }



    public function cambioEstadoReportePendiente(FilterReporteEvent $event)
    {
        $this->cambioEstado($event,'PR' );
    }

    public function cambioEstadoReporteCompletado(FilterReporteEvent $event)
    {
        $this->cambioEstado($event, 'CO');
    }

    public function cambioEstado(FilterReporteEvent $event, $estado)
    {
        $reporte = $event->getReporte();
        $this->reporteManager->cambiarEstado($reporte,$estado);
    }

    public function crearDiagnostico(FilterReporteEvent $event)
    {
        $reporte = $event->getReporte();

        $this->diagnosticoManager->crearDiagnostico($reporte);
    }

}