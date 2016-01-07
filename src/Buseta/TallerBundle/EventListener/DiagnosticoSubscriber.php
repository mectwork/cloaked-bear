<?php

namespace Buseta\TallerBundle\EventListener;



use Buseta\TallerBundle\Event\FilterDiagnosticoEvent;
use Buseta\TallerBundle\Event\DiagnosticoEvents;
use Buseta\TallerBundle\Manager\DiagnosticoManager;
use Buseta\TallerBundle\Manager\OrdenTrabajoManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DiagnosticoSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\TallerBundle\Manager\DiagnosticoManager
     */
    private $diagnosticoManager;

    /**
     * @var \Buseta\TallerBundle\Manager\OrdenTrabajoManager
     */
    private $ordenTrabajoManager;



    /**
     * @param \Buseta\TallerBundle\Manager\DiagnosticoManager $diagnosticoManager
     * @param \Buseta\TallerBundle\Manager\OrdenTrabajoManager $ordenTrabajoManager
     */
    function __construct(DiagnosticoManager $diagnosticoManager, OrdenTrabajoManager $ordenTrabajoManager)
    {
        $this->diagnosticoManager = $diagnosticoManager;
        $this->ordenTrabajoManager = $ordenTrabajoManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(

            DiagnosticoEvents::CAMBIAR_CANCELADO   => 'cambiarCancelado',
            DiagnosticoEvents::PROCESAR_DIAGNOSTICO => 'crearOrdenTrabajo',
            DiagnosticoEvents::CAMBIAR_ESTADO_PR   => 'cambioEstadoDiagnosticoPendiente',
            DiagnosticoEvents::CAMBIAR_ESTADO_CO  => 'cambioEstadoDiagnosticoCompletado',
        );
    }



    public function cambiarCancelado(FilterDiagnosticoEvent $event)
    {
        $diagnostico = $event->getDiagnostico();
        $this->diagnosticoManager->cambiarCancelado($diagnostico);
    }

    public function cambioEstadoDiagnosticoPendiente(FilterDiagnosticoEvent $event)
    {
        $this->cambioEstado($event,'PR' );
    }

    public function cambioEstadoDiagnosticoCompletado(FilterDiagnosticoEvent $event)
    {
        $this->cambioEstado($event, 'CO');
    }

    public function cambioEstado(FilterDiagnosticoEvent $event, $estado)
    {
        $diagnostico = $event->getDiagnostico();
        $this->diagnosticoManager->cambiarEstado($diagnostico,$estado);
    }

    public function crearOrdenTrabajo(FilterDiagnosticoEvent $event)
    {
        $diagnostico = $event->getDiagnostico();

        $this->ordenTrabajoManager->crearOrdenTrabajo($diagnostico);
    }

}
