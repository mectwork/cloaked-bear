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

            foreach ($salidaBodega->getSalidasProductos() as $salidaBodegaLinea) {
                /** @var SalidaBodegaProducto $salidaBodegaLinea */
                $bitacoraEvent = new BitacoraEventModel();
                $bitacoraEvent->setProduct($salidaBodegaLinea->getProducto());
                $bitacoraEvent->setWarehouse($salidaBodega->getAlmacenOrigen());
                $bitacoraEvent->setMovementQty($salidaBodegaLinea->getCantidad());
                $bitacoraEvent->setMovementDate(new \DateTime());
                $bitacoraEvent->setMovementType(BusetaBodegaMovementTypes::INTERNAL_CONSUMPTION_MINUS);
                $bitacoraEvent->setReferencedObject($salidaBodegaLinea);
                $bitacoraEvent->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($salidaBodegaLinea) {
                    $bitacoraAlmacen->setConsumoInterno(sprintf(
                        '%s,%d',
                        ClassUtils::getRealClass($salidaBodegaLinea),
                        $salidaBodegaLinea->getId()
                    ));
                });
                $this->bitacoraEvents->add($bitacoraEvent);
            }
        }
    }
}
