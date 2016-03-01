<?php

namespace Buseta\BodegaBundle\Event\BitacoraBodega;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Model\BitacoraEventModel;

/**
 * Class BitacoraMovimientoEvent
 *
 * @package Buseta\BodegaBundle\Event\BitacoraBodega
 */
class BitacoraMovimientoEvent extends AbstractBitacoraEvent
{
    /**
     * @var Movimiento
     */
    private $movimiento;


    /**
     * BitacoraMovimientoEvent constructor.
     *
     * @param Movimiento $movimiento
     * @param bool       $flush
     */
    public function __construct(Movimiento $movimiento=null, $flush=false)
    {
        parent::__construct($flush);

        if ($movimiento !== null && $movimiento->getMovimientosProductos()->count() > 0) {
            $this->movimiento = $movimiento;
            foreach ($movimiento->getMovimientosProductos() as $movimientoLinea) {
                /** @var MovimientosProductos $movimientoLinea */
                $bitacoraEventTo = new BitacoraEventModel();
                $bitacoraEventTo->setProduct($movimientoLinea->getProducto());
                $bitacoraEventTo->setWarehouse($movimiento->getAlmacenDestino());
                $bitacoraEventTo->setMovementQty($movimientoLinea->getCantidad());
                $bitacoraEventTo->setMovementDate(new \DateTime());
                $bitacoraEventTo->setMovementType(BusetaBodegaMovementTypes::MOVEMENT_TO);
                $bitacoraEventTo->setReferencedObject($movimientoLinea);
                $bitacoraEventTo->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($movimientoLinea) {
                    $bitacoraAlmacen->setMovimientoLinea($movimientoLinea);
                });
                $this->bitacoraEvents->add($bitacoraEventTo);

                $bitacoraEventFrom = new BitacoraEventModel();
                $bitacoraEventFrom->setProduct($movimientoLinea->getProducto());
                $bitacoraEventFrom->setWarehouse($movimiento->getAlmacenOrigen());
                $bitacoraEventFrom->setMovementQty($movimientoLinea->getCantidad());
                $bitacoraEventFrom->setMovementDate(new \DateTime());
                $bitacoraEventFrom->setMovementType(BusetaBodegaMovementTypes::MOVEMENT_FROM);
                $bitacoraEventFrom->setReferencedObject($movimientoLinea);
                $bitacoraEventFrom->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($movimientoLinea) {
                    $bitacoraAlmacen->setMovimientoLinea($movimientoLinea);
                });
                $this->bitacoraEvents->add($bitacoraEventFrom);
            }
        }
    }
}
