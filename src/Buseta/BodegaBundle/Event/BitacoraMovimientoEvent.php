<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BitacoraMovimientoEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class BitacoraMovimientoEvent extends Event implements BitacoraEventInterface
{
    /**
     * @var Movimiento
     */
    private $movimiento;

    /**
     * @var ArrayCollection
     */
    private $bitacoraEvents;

    /**
     * @var string
     */
    private $error;


    /**
     * BitacoraMovimientoEvent constructor.
     *
     * @param Movimiento $movimiento
     */
    public function __construct(Movimiento $movimiento = null)
    {
        $this->bitacoraEvents = new ArrayCollection();
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

    /**
     * @return ArrayCollection
     */
    public function getBitacoraEvents()
    {
        return $this->bitacoraEvents;
    }

    /**
     * @param BitacoraEventModel $bitacoraEventModel
     */
    public function addBitacoraEvent(BitacoraEventModel $bitacoraEventModel)
    {
        $this->bitacoraEvents->add($bitacoraEventModel);
    }

    /**
     * {@inheritdoc}
     */
    public function getError()
    {
        return $this->error;
    }

    public function setError($error)
        /**
         * @param string $error
         */
    {
        $this->error = $error;
    }
}
