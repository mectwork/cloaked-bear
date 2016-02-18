<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BitacoraAlbaranEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class BitacoraAlbaranEvent extends Event implements BitacoraEventInterface
{
    /**
     * @var Albaran
     */
    private $albaran;

    /**
     * @var ArrayCollection
     */
    private $bitacoraEvents;

    /**
     * @var string
     */
    private $error;


    /**
     * BitacoraAlbaranEvent constructor.
     *
     * @param Albaran $albaran
     */
    public function __construct(Albaran $albaran = null)
    {
        $this->bitacoraEvents = new ArrayCollection();
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
     * @param BitacoraEventModel $bitacoraEvent
     */
    public function addBitacoraEvent(BitacoraEventModel $bitacoraEvent)
    {
        $this->bitacoraEvents->add($bitacoraEvent);
    }

    /**
     * {@inheritdoc}
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
