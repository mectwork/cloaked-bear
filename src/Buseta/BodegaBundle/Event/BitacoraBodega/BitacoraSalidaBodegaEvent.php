<?php

namespace Buseta\BodegaBundle\Event\BitacoraBodega;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Entity\SalidaBodegaProducto;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class BitacoraSalidaBodegaEvent
 *
 * @package Buseta\BodegaBundle\Event\BitacoraBodega
 */
class BitacoraSalidaBodegaEvent extends AbstractBitacoraEvent
{
    /**
     * @var SalidaBodega
     */
    private $salidaBodega;


    /**
     * BitacoraSalidaBodegaEvent constructor.
     *
     * @param SalidaBodega $salidaBodega
     * @param bool         $flush
     */
    public function __construct(SalidaBodega $salidaBodega=null, $flush=false)
    {
        parent::__construct($flush);

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
}
