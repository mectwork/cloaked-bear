<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;

use Buseta\BodegaBundle\Entity\BitacoraSerial;
use Buseta\BodegaBundle\Event\BitacoraBodega\BitacoraAlbaranEvent;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Buseta\BodegaBundle\Model\BitacoraSerialEventModel;

/**
 * Class BitacoraSerialAlbaranEvent
 *
 * @package Buseta\BodegaBundle\Event\BitacoraSerial
 */
class BitacoraSerialAlbaranEvent extends AbstractBitacoraSerialEvent
{
    /**
     * @var BitacoraAlbaranEvent
     */
    private $albaranEvent;


    /**
     * BitacoraSerialAlbaranEvent constructor.
     *
     * @param BitacoraAlbaranEvent $albaranEvent
     */
    public function __construct(BitacoraAlbaranEvent $albaranEvent=null)
    {
        parent::__construct($albaranEvent->isFlush());

        if ($albaranEvent !== null && $albaranEvent->getBitacoraEvents()->count() > 0) {
            $this->albaranEvent = $albaranEvent;

            $fillBitacoraSerialEvents = function (BitacoraEventModel $albaranEventLinea, $serial) {
                $bitacoraSerialEvent = new BitacoraSerialEventModel();
                $bitacoraSerialEvent->setWarehouse($albaranEventLinea->getWarehouse());
                $bitacoraSerialEvent->setProduct($albaranEventLinea->getProduct());
                $bitacoraSerialEvent->setMovementQty(1);
                $bitacoraSerialEvent->setSerial($serial);
                $bitacoraSerialEvent->setMovementDate($albaranEventLinea->getMovementDate());
                $bitacoraSerialEvent->setMovementType($albaranEventLinea->getMovementType());
                $bitacoraSerialEvent->setCallback(function (BitacoraSerial $bitacoraSerial) use ($albaranEventLinea){
                    if ($albaranEventLinea !== null && $albaranEventLinea->getBitacoraLine() !== null) {
                        $bitacoraSerial
                            ->setEntradaSalidaLinea($albaranEventLinea->getBitacoraLine()->getEntradaSalidaLinea());
                    }
                });

                $this->bitacoraSerialEvents->add($bitacoraSerialEvent);
            };

            foreach ($albaranEvent->getBitacoraEvents() as $albaranEventLinea) {
                /** @var BitacoraEventModel $albaranEventLinea */
                $albaranLinea = $albaranEventLinea->getBitacoraLine()->getEntradaSalidaLinea();
                $strSeriales = $albaranLinea->getSeriales();
                $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                foreach ($seriales as $serial) {
                    call_user_func($fillBitacoraSerialEvents, $albaranEventLinea, $serial);
                }
            }
        }
    }
}
