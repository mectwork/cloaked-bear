<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;

use Buseta\BodegaBundle\Entity\BitacoraSerial;
use Buseta\BodegaBundle\Entity\SalidaBodegaProducto;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraSalidaBodegaEvent;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Buseta\BodegaBundle\Model\BitacoraSerialEventModel;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class BitacoraSerialSalidaBodegaEvent
 *
 * @package Buseta\BodegaBundle\Event\BitacoraBodega
 */
class BitacoraSerialSalidaBodegaEvent extends AbstractBitacoraSerialEvent
{
    /**
     * @var BitacoraSalidaBodegaEvent
     */
    private $salidaBodegaEvent;


    /**
     * BitacoraSalidaBodegaEvent constructor.
     *
     * @param BitacoraSalidaBodegaEvent $salidaBodegaEvent
     */
    public function __construct(BitacoraSalidaBodegaEvent $salidaBodegaEvent=null)
    {
        if (null === $salidaBodegaEvent) {
            return;
        }

        parent::__construct($salidaBodegaEvent->isFlush());

        if ($salidaBodegaEvent->getBitacoraEvents()->count() > 0) {
            $this->salidaBodegaEvent = $salidaBodegaEvent;

            $fillBitacoraSerialEvents = function (BitacoraEventModel $salidaBodegaEventLinea, $serial) {
                $bitacoraSerialEvent = new BitacoraSerialEventModel();
                $bitacoraSerialEvent->setWarehouse($salidaBodegaEventLinea->getWarehouse());
                $bitacoraSerialEvent->setProduct($salidaBodegaEventLinea->getProduct());
                $bitacoraSerialEvent->setMovementQty(1);
                $bitacoraSerialEvent->setSerial($serial);
                $bitacoraSerialEvent->setMovementDate($salidaBodegaEventLinea->getMovementDate());
                $bitacoraSerialEvent->setMovementType($salidaBodegaEventLinea->getMovementType());
                $bitacoraSerialEvent->setCallback(function (BitacoraSerial $bitacoraSerial) use ($salidaBodegaEventLinea){
                    $salidaBodegaLinea = $salidaBodegaEventLinea->getReferencedObject();
                    $bitacoraSerial->setConsumoInterno(sprintf(
                        '%s,%d',
                        ClassUtils::getRealClass($salidaBodegaLinea),
                        $salidaBodegaLinea->getId()
                    ));
                });
                $this->bitacoraSerialEvents->add($bitacoraSerialEvent);
            };

            foreach ($salidaBodegaEvent->getBitacoraEvents() as $salidaBodegaEventLinea) {
                /** @var BitacoraEventModel $salidaBodegaEventLinea */
                $salidaBodegaLinea = $salidaBodegaEventLinea->getReferencedObject();
                if (null !== $salidaBodegaLinea && $salidaBodegaLinea instanceof SalidaBodegaProducto) {
                    /** @var SalidaBodegaProducto $salidaBodegaLinea */
                    $strSeriales = $salidaBodegaLinea->getSeriales();
                    $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                    foreach ($seriales as $serial) {
                        call_user_func($fillBitacoraSerialEvents, $salidaBodegaEventLinea, $serial);
                    }
                }
            }
        }
    }
}
