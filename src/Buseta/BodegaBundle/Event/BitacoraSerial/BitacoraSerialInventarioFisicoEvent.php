<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;


use Buseta\BodegaBundle\Entity\BitacoraSerial;
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

            $fillBitacoraSerialEvents = function (BitacoraEventModel $inventarioFisicoEventLinea, $serial) {
                $bitacoraSerialEvent = new BitacoraSerialEventModel();
                $bitacoraSerialEvent->setWarehouse($inventarioFisicoEventLinea->getWarehouse());
                $bitacoraSerialEvent->setProduct($inventarioFisicoEventLinea->getProduct());
                $bitacoraSerialEvent->setMovementQty(1);
                $bitacoraSerialEvent->setSerial($serial);
                $bitacoraSerialEvent->setMovementDate($inventarioFisicoEventLinea->getMovementDate());
                $bitacoraSerialEvent->setMovementType($inventarioFisicoEventLinea->getMovementType());
                $bitacoraSerialEvent->setCallback(function (BitacoraSerial $bitacoraSerial) use ($inventarioFisicoEventLinea){
                    if ($inventarioFisicoEventLinea !== null && $inventarioFisicoEventLinea->getBitacoraLine() !== null) {
                        $bitacoraSerial
                            ->setInventarioLinea($inventarioFisicoEventLinea->getBitacoraLine()->getInventarioLinea());
                    }
                });

                $this->bitacoraSerialEvents->add($bitacoraSerialEvent);
            };

            foreach ($inventarioFisicoEvent->getBitacoraEvents() as $inventarioEvent) {
                /** @var BitacoraEventModel $inventarioEvent */
                $inventarioLinea = $inventarioEvent->getBitacoraLine()->getInventarioLinea();
                $strSeriales = $inventarioLinea->getSeriales();
                $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                foreach ($seriales as $serial) {
                    call_user_func($fillBitacoraSerialEvents, $inventarioEvent, $serial);
                }
            }
        }
    }
}
