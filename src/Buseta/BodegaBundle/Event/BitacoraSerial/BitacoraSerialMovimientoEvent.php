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
                $bitacoraSerialEvent = new BitacoraSerialEventModel();
                $bitacoraSerialEvent->setWarehouse($movimientoEventLinea->getWarehouse());
                $bitacoraSerialEvent->setProduct($movimientoEventLinea->getProduct());
                $bitacoraSerialEvent->setMovementQty(1);
                $bitacoraSerialEvent->setSerial($serial);
                $bitacoraSerialEvent->setMovementDate($movimientoEventLinea->getMovementDate());
                $bitacoraSerialEvent->setMovementType($movimientoEventLinea->getMovementType());
                $bitacoraSerialEvent->setCallback(function (BitacoraSerial $bitacoraSerial) use ($movimientoEventLinea){
                    $bitacoraSerial->setMovimientoLinea($movimientoEventLinea->getReferencedObject());
                });
                $this->bitacoraSerialEvents->add($bitacoraSerialEvent);
            };

            foreach ($movimientoEvent->getBitacoraEvents() as $movimientoLineaEvent) {
                /** @var BitacoraEventModel $movimientoLineaEvent */
                $movimientoLinea = $movimientoLineaEvent->getReferencedObject();
                if (null !== $movimientoLinea && $movimientoLinea instanceof MovimientosProductos) {
                    $producto = $movimientoLinea->getProducto();
                    if ($producto->getTieneNroSerie()) { // check if product line supports serials
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
}
