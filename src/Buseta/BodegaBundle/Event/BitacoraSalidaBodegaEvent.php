<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Entity\SalidaBodegaProducto;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class BitacoraSalidaBodegaEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class BitacoraSalidaBodegaEvent extends Event implements BitacoraEventInterface
{
    /**
     * @var SalidaBodega
     */
    private $salidaBodega;

    /**
     * @var ArrayCollection
     */
    private $bitacoraEvents;

    /**
     * @var string
     */
    private $error;


    /**
     * BitacoraSalidaBodegaEvent constructor.
     *
     * @param $salidaBodega
     */
    public function __construct(SalidaBodega $salidaBodega = null)
    {
        $this->bitacoraEvents = new ArrayCollection();
        if ($salidaBodega !== null && $salidaBodega->getSalidasProductos()->count() > 0) {
            $this->salidaBodega = $salidaBodega;

            foreach ($salidaBodega->getSalidasProductos() as $salidaProducto) {
                /** @var SalidaBodegaProducto $salidaProducto */
                $bitacoraEvent = new BitacoraEventModel();
                $bitacoraEvent->setProduct($salidaProducto->getProducto());
                $bitacoraEvent->setWarehouse($salidaBodega->getAlmacenOrigen());
                $bitacoraEvent->setMovementQty($salidaProducto->getCantidad());
                $bitacoraEvent->setMovementDate(new \DateTime());
                $bitacoraEvent->setMovementType(BusetaBodegaMovementTypes::INTERNAL_CONSUMPTION_MINUS);
                $bitacoraEvent->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($salidaProducto) {
                    $bitacoraAlmacen->setConsumoInterno(sprintf(
                        '%s,%d',
                        ClassUtils::getRealClass($salidaProducto),
                        $salidaProducto->getId()
                    ));
                });

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

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}
