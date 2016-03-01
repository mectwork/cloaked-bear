<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;


use Buseta\BodegaBundle\Entity\BitacoraSerial;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraInventarioFisicoEvent;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Buseta\BodegaBundle\Model\BitacoraSerialEventModel;

class BitacoraSerialInventarioFisicoEvent extends AbstractBitacoraSerialEvent
{
    /**
     * @var BitacoraInventarioFisicoEvent
     */
    private $inventarioFisicoEvent;


    /**
     * BitacoraSerialInventarioFisicoEvent constructor.
     *
     * @param $inventarioFisicoEvent
     */
    public function __construct(BitacoraInventarioFisicoEvent $inventarioFisicoEvent=null)
    {
        if (null === $inventarioFisicoEvent) {
            return;
        }

        parent::__construct($inventarioFisicoEvent->isFlush());

        if ($inventarioFisicoEvent->getBitacoraEvents()->count() > 0) {
            $this->inventarioFisicoEvent = $inventarioFisicoEvent;

            $fillBitacoraSerialEvents = function (BitacoraEventModel $inventarioFisicoLineaEvent, $serial) {
                $bitacoraSerialEvent = new BitacoraSerialEventModel();
                $bitacoraSerialEvent->setWarehouse($inventarioFisicoLineaEvent->getWarehouse());
                $bitacoraSerialEvent->setProduct($inventarioFisicoLineaEvent->getProduct());
                $bitacoraSerialEvent->setMovementQty(1);
                $bitacoraSerialEvent->setSerial($serial);
                $bitacoraSerialEvent->setMovementDate($inventarioFisicoLineaEvent->getMovementDate());
                $bitacoraSerialEvent->setMovementType($inventarioFisicoLineaEvent->getMovementType());
                $bitacoraSerialEvent->setCallback(function (BitacoraSerial $bitacoraSerial) use ($inventarioFisicoLineaEvent){
                    $bitacoraSerial->setInventarioLinea($inventarioFisicoLineaEvent->getReferencedObject());
                });
                $this->bitacoraSerialEvents->add($bitacoraSerialEvent);
            };

            foreach ($inventarioFisicoEvent->getBitacoraEvents() as $inventarioFisicoLineaEvent) {
                /** @var BitacoraEventModel $inventarioFisicoLineaEvent */
                $inventarioLinea = $inventarioFisicoLineaEvent->getReferencedObject();
                if (null !== $inventarioLinea && $inventarioLinea instanceof InventarioFisicoLinea) {
                    $producto = $inventarioLinea->getProducto();
                    if ($producto->getTieneNroSerie()) { // check if product line supports serials
                        $strSeriales = $inventarioLinea->getSeriales();
                        $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                        foreach ($seriales as $serial) {
                            call_user_func($fillBitacoraSerialEvents, $inventarioFisicoLineaEvent, $serial);
                        }
                    }
                }
            }
        }
    }
}
