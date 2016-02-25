<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;

use Buseta\BodegaBundle\Entity\BitacoraSerial;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraMovimientoEvent;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Buseta\BodegaBundle\Model\BitacoraSerialEventModel;

/**
 * Class BitacoraSerialMovimientoEvent
 *
 * @package Buseta\BodegaBundle\Event\BitacoraBodega
 */
class BitacoraSerialMovimientoEvent extends AbstractBitacoraSerialEvent
{
    /**
     * @var BitacoraMovimientoEvent
     */
    private $movimientoEvent;


    /**
     * BitacoraSerialMovimientoEvent constructor.
     *
     * @param BitacoraMovimientoEvent $movimientoEvent
     */
    public function __construct(BitacoraMovimientoEvent $movimientoEvent=null)
    {
        if (null === $movimientoEvent) {
            return;
        }

        parent::__construct($movimientoEvent->isFlush());

        if ($movimientoEvent->getBitacoraEvents()->count() > 0) {
            $this->movimientoEvent = $movimientoEvent;

            $fillBitacoraSerialEvents = function (BitacoraEventModel $movimientoEventLinea, $serial) {
                $bitacoraSerialEventTo = new BitacoraSerialEventModel();
                $bitacoraSerialEventTo->setWarehouse($movimientoEventLinea->getWarehouse());
                $bitacoraSerialEventTo->setProduct($movimientoEventLinea->getProduct());
                $bitacoraSerialEventTo->setMovementQty(1);
                $bitacoraSerialEventTo->setSerial($serial);
                $bitacoraSerialEventTo->setMovementDate($movimientoEventLinea->getMovementDate());
                $bitacoraSerialEventTo->setMovementType($movimientoEventLinea->getMovementType());
                $bitacoraSerialEventTo->setCallback(function (BitacoraSerial $bitacoraSerial) use ($movimientoEventLinea){
                    $bitacoraSerial->setMovimientoLinea($movimientoEventLinea->getReferencedObject());
                });
                $this->bitacoraSerialEvents->add($bitacoraSerialEventTo);

                $bitacoraSerialEventFrom = new BitacoraSerialEventModel();
                $bitacoraSerialEventFrom->setWarehouse($movimientoEventLinea->getWarehouse());
                $bitacoraSerialEventFrom->setProduct($movimientoEventLinea->getProduct());
                $bitacoraSerialEventFrom->setMovementQty(1);
                $bitacoraSerialEventFrom->setSerial($serial);
                $bitacoraSerialEventFrom->setMovementDate($movimientoEventLinea->getMovementDate());
                $bitacoraSerialEventFrom->setMovementType($movimientoEventLinea->getMovementType());
                $bitacoraSerialEventFrom->setCallback(function (BitacoraSerial $bitacoraSerial) use ($movimientoEventLinea){
                    $bitacoraSerial->setMovimientoLinea($movimientoEventLinea->getReferencedObject());
                });
                $this->bitacoraSerialEvents->add($bitacoraSerialEventFrom);
            };

            foreach ($movimientoEvent->getBitacoraEvents() as $movimientoLineaEvent) {
                /** @var BitacoraEventModel $movimientoLineaEvent */
                $movimientoLinea = $movimientoLineaEvent->getReferencedObject();
                if (null !== $movimientoLinea && $movimientoLinea instanceof MovimientosProductos) {
                    $strSeriales = $movimientoLinea->getSeriales();
                    $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                    foreach ($seriales as $serial) {
                        call_user_func($fillBitacoraSerialEvents, $movimientoLineaEvent, $serial);
                    }
                }
            }
        }
    }
}
