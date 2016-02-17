<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\InventarioFisico;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BitacoraInventarioFisicoEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class BitacoraInventarioFisicoEvent extends Event implements BitacoraEventInterface
{
    /**
     * @var InventarioFisico
     */
    private $inventarioFisico;

    /**
     * @var ArrayCollection
     */
    private $bitacoraEvents;

    /**
     * @var string
     */
    private $error;

    /**
     * BitacoraInventarioFisicoEvent constructor.
     *
     * @param InventarioFisico $inventarioFisico
     */
    public function __construct(InventarioFisico $inventarioFisico = null)
    {
        $this->bitacoraEvents = new ArrayCollection();
        if ($inventarioFisico !== null && $inventarioFisico->getInventarioFisicoLineas()->count() > 0) {
            $this->inventarioFisico = $inventarioFisico;
            foreach ($inventarioFisico->getInventarioFisicoLineas() as $inventarioFisicoLinea) {
                $movementQty = $inventarioFisicoLinea->getCantidadReal() - $inventarioFisicoLinea->getCantidadTeorica();
                if ($movementQty == 0) {
                    continue;
                }
                /** @var InventarioFisicoLinea $inventarioFisicoLinea */
                $bitacoraEvent = new BitacoraEvent();
                $bitacoraEvent->setProduct($inventarioFisicoLinea->getProducto());
                $bitacoraEvent->setWarehouse($inventarioFisico->getAlmacen());
                $bitacoraEvent->setMovementQty(abs($movementQty));
                $bitacoraEvent->setMovementDate($inventarioFisico->getFecha());
                $bitacoraEvent->setMovementType(
                    $movementQty > 0 ? BusetaBodegaMovementTypes::INVENTORY_IN : BusetaBodegaMovementTypes::INVENTORY_OUT);

                $this->bitacoraEvents->add($bitacoraEvent);
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
     * @param BitacoraEvent $bitacoraEvent
     */
    public function addBitacoraEvent(BitacoraEvent $bitacoraEvent)
    {
        $this->bitacoraEvents->add($bitacoraEvent);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}
