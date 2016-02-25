<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;

use Buseta\BodegaBundle\Entity\BitacoraSerial;
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
                    if ($movimientoEventLinea !== null && $movimientoEventLinea->getBitacoraLine() !== null) {
                        $bitacoraSerial
                            ->setMovimientoLinea($movimientoEventLinea->getBitacoraLine()->getMovimientoLinea());
                    }
                });

                $bitacoraSerialEventFrom = new BitacoraSerialEventModel();
                $bitacoraSerialEventFrom->setWarehouse($movimientoEventLinea->getWarehouse());
                $bitacoraSerialEventFrom->setProduct($movimientoEventLinea->getProduct());
                $bitacoraSerialEventFrom->setMovementQty(1);
                $bitacoraSerialEventFrom->setSerial($serial);
                $bitacoraSerialEventFrom->setMovementDate($movimientoEventLinea->getMovementDate());
                $bitacoraSerialEventFrom->setMovementType($movimientoEventLinea->getMovementType());
                $bitacoraSerialEventFrom->setCallback(function (BitacoraSerial $bitacoraSerial) use ($movimientoEventLinea){
                    if ($movimientoEventLinea !== null && $movimientoEventLinea->getBitacoraLine() !== null) {
                        $bitacoraSerial
                            ->setMovimientoLinea($movimientoEventLinea->getBitacoraLine()->getMovimientoLinea());
                    }
                });

                $this->bitacoraSerialEvents->add($bitacoraSerialEventTo);
                $this->bitacoraSerialEvents->add($bitacoraSerialEventFrom);
            };

            foreach ($movimientoEvent->getBitacoraEvents() as $movimientoEventLinea) {
                /** @var BitacoraEventModel $movimientoEventLinea */
                $movimientoLinea = $movimientoEventLinea->getBitacoraLine()->getMovimientoLinea();
                $strSeriales = $movimientoLinea->getSeriales();
                $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                foreach ($seriales as $serial) {
                    call_user_func($fillBitacoraSerialEvents, $movimientoEventLinea, $serial);
                }
            }
        }
    }
}
