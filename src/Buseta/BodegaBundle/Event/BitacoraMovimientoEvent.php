<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Model\BitacoraEventModel;

/**
 * Class BitacoraMovimientoEvent
 *
 * @package Buseta\BodegaBundle\Event
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
     */
    public function __construct(Movimiento $movimiento=null, $flush=false)
    {
        parent::__construct($flush);

        if ($movimiento !== null && $movimiento->getMovimientosProductos()->count() > 0) {
            $this->movimiento = $movimiento;
            foreach ($movimiento->getMovimientosProductos() as $movimientoProducto) {
                /** @var MovimientosProductos $movimientoProducto */
                $bitacoraEventTo = new BitacoraEventModel();
                $bitacoraEventTo->setProduct($movimientoProducto->getProducto());
                $bitacoraEventTo->setWarehouse($movimiento->getAlmacenDestino());
                $bitacoraEventTo->setMovementQty($movimientoProducto->getCantidad());
                $bitacoraEventTo->setMovementDate($movimiento->getFechaMovimiento());
                $bitacoraEventTo->setMovementType(BusetaBodegaMovementTypes::MOVEMENT_TO);
                $bitacoraEventTo->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($movimientoProducto) {
                    $bitacoraAlmacen->setMovimientoLinea($movimientoProducto);
                });

                $bitacoraEventFrom = new BitacoraEventModel();
                $bitacoraEventFrom->setProduct($movimientoProducto->getProducto());
                $bitacoraEventFrom->setWarehouse($movimiento->getAlmacenOrigen());
                $bitacoraEventFrom->setMovementQty($movimientoProducto->getCantidad());
                $bitacoraEventFrom->setMovementDate($movimiento->getFechaMovimiento());
                $bitacoraEventFrom->setMovementType(BusetaBodegaMovementTypes::MOVEMENT_FROM);
                $bitacoraEventFrom->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($movimientoProducto) {
                    $bitacoraAlmacen->setMovimientoLinea($movimientoProducto);
                });

                $this->bitacoraEvents->add($bitacoraEventTo);
                $this->bitacoraEvents->add($bitacoraEventFrom);
            }
        }
    }
}
