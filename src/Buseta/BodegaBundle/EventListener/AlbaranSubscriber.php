<?php

namespace Buseta\BodegaBundle\EventListener;


use Buseta\BodegaBundle\Event\FilterAlbaranEvent;
use Buseta\BodegaBundle\Event\AlbaranEvents;
use Buseta\BodegaBundle\Manager\AlbaranManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AlbaranSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\BodegaBundle\Manager\AlbaranManager
     */
    private $albaranManager;


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
            AlbaranEvents::POS_PROCESS  => 'cambiarestadoProcesado',
            AlbaranEvents::POS_COMPLETE => 'cambiarestadoCompletado',
        );
    }

    public function cambiarestadoProcesado(FilterAlbaranEvent $event)
    {
        $this->cambiarEstado($event, 'PR');
    }

    public function cambiarestadoCompletado(FilterAlbaranEvent $event)
    {
        $this->cambiarEstado($event, 'CO');
    }


    public function cambiarEstado(FilterAlbaranEvent $event, $estado )
    {
        $albaran = $event->getEntityData();
        //Si hay error devuelve false, si to ok devuelve true
        $resultadobooleano =  $this->albaranManager->cambiarEstado( $albaran , $estado );
        $event->setReturnValue( $resultadobooleano );
    }
}
