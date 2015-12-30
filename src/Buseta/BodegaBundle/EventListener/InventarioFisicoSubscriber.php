<?php

namespace Buseta\BodegaBundle\EventListener;

use Buseta\BodegaBundle\Event\FilterInventarioFisicoEvent;
use Buseta\BodegaBundle\Event\InventarioFisicoEvents;
use Buseta\BodegaBundle\Manager\InventarioFisicoManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InventarioFisicoSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\BodegaBundle\Manager\InventarioFisicoManager
     */
    private $inventariofisicoManager;


    /**
     * @param \Buseta\BodegaBundle\Manager\InventarioFisicoManager $inventariofisicoManager
     */
    function __construct(InventarioFisicoManager $inventariofisicoManager)
    {
        $this->inventariofisicoManager  = $inventariofisicoManager;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            InventarioFisicoEvents::POS_PROCESS  => 'cambiarestadoProcesado',
            InventarioFisicoEvents::POS_COMPLETE => 'cambiarestadoCompletado',
        );
    }

    public function cambiarestadoProcesado(FilterInventarioFisicoEvent $event)
    {
        $this->cambiarEstado($event, 'PR');
    }

    public function cambiarestadoCompletado(FilterInventarioFisicoEvent $event)
    {
        $this->cambiarEstado($event, 'CO');
    }


    public function cambiarEstado(FilterInventarioFisicoEvent $event, $estado )
    {
        $inventariofisico = $event->getEntityData();
        //Si hay error devuelve false, si to ok devuelve true
        $resultadobooleano =  $this->inventariofisicoManager->cambiarEstado( $inventariofisico , $estado );
        $event->setReturnValue( $resultadobooleano );
    }
}
