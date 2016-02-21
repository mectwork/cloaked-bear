<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BitacoraAlbaranEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class BitacoraAlbaranEvent extends AbstractBitacoraEvent
{
    /**
     * @var Albaran
     */
    private $albaran;


    /**
     * BitacoraAlbaranEvent constructor.
     *
     * @param Albaran $albaran
     * @param boolean $flush
     */
    public function __construct(Albaran $albaran = null, $flush=false)
    {
        parent::__construct($flush);

        if ($albaran !== null && $albaran->getAlbaranLineas()->count() > 0) {
            $this->albaran = $albaran;

            foreach ($albaran->getAlbaranLineas() as $albaranLinea) {
                /** @var AlbaranLinea $albaranLinea */
                $bitacoraEvent = new BitacoraEventModel();
                $bitacoraEvent->setWarehouse($albaranLinea->getAlmacen());
                $bitacoraEvent->setProduct($albaranLinea->getProducto());
                $bitacoraEvent->setMovementQty($albaranLinea->getCantidadMovida());
                $bitacoraEvent->setMovementDate(new \DateTime());
                $bitacoraEvent->setMovementType(BusetaBodegaMovementTypes::VENDOR_RECEIPTS);
                $bitacoraEvent->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($albaranLinea){
                    $bitacoraAlmacen->setEntradaSalidaLinea($albaranLinea);
                });

                $this->bitacoraEvents->add($bitacoraEvent);
            }
        }
    }
}
