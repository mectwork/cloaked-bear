<?php

namespace Buseta\BodegaBundle\EventListener;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Event\LegacyBitacoraEvent;
use Buseta\BodegaBundle\Exceptions\NotValidBitacoraTypeException;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Buseta\BodegaBundle\Manager\BitacoraAlmacenManager;
use Buseta\BodegaBundle\Manager\BitacoraSerialManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class BitacoraSubscriber
 * @package Buseta\BodegaBundle\EventListener
 */
class BitacoraSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\BodegaBundle\Manager\BitacoraAlmacenManager
     */
    private $bitacoraAlmacenManager;


    /**
     * @var \Buseta\BodegaBundle\Manager\BitacoraSerialManager
     */
    private $bitacoraSerialManager;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;


    /**
     * @param \Buseta\BodegaBundle\Manager\BitacoraAlmacenManager $bitacoraAlmacenManager
     * @param \Buseta\BodegaBundle\Manager\BitacoraSerialManager $bitacoraSerialManager
     * @param Logger $logger
     */
    function __construct(
        BitacoraAlmacenManager $bitacoraAlmacenManager,
        BitacoraSerialManager $bitacoraSerialManager,
        Logger $logger
    ) {
        $this->bitacoraAlmacenManager = $bitacoraAlmacenManager;
        $this->bitacoraSerialManager = $bitacoraSerialManager;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            /* C+ */
            BitacoraEvents::CUSTOMER_RETURNS => 'customerReturns',
            /* C- */
            BitacoraEvents::CUSTOMER_SHIPMENT => 'customerShipment',
            /* D+ */
            BitacoraEvents::INTERNAL_CONSUMPTION_POSITIVE => 'internalConsumptionPositive',
            /* D- */
            BitacoraEvents::INTERNAL_CONSUMPTION_NEGATIVE => 'internalConsumptionNegative',
            /* I+ */
            BitacoraEvents::INVENTORY_IN => 'inventoryIn',
            /* I- */
            BitacoraEvents::INVENTORY_OUT => 'inventoryOut',
            /* M+ */
            BitacoraEvents::MOVEMENT_TO => 'movementTo',
            /* M- */
            BitacoraEvents::MOVEMENT_FROM => 'movementFrom',
            /* P+ */
            BitacoraEvents::PRODUCTION_POSITIVE => 'productionPositive',
            /* P- */
            BitacoraEvents::PRODUCTION_NEGATIVE => 'productionNegative',
            /* V+ */
            BitacoraEvents::VENDOR_RECEIPTS => 'vendorReceipts',
            /* V- */
            BitacoraEvents::VENDOR_RETURNS => 'vendorReturns',
            /* W+ */
            BitacoraEvents::WORK_ORDER_POSITIVE => 'workOrderPositive',
            /* W- */
            BitacoraEvents::WORK_ORDER_NEGATIVE => 'workOrderNegative',
        );
    }

    public function customerReturns(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'C+');
    }

    public function customerShipment(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'C-');
    }

    public function internalConsumptionPositive(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'D+');
    }

    public function internalConsumptionNegative(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'D-');
    }

    public function inventoryIn(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'I+');
    }

    public function inventoryOut(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'I-');
    }

    public function movementTo(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'M+');
    }

    public function movementFrom(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'M-');
    }

    public function productionPositive(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'P+');
    }

    public function productionNegative(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'P-');
    }

    public function vendorReceipts(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'V+');
    }

    public function vendorReturns(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'V-');
    }

    public function workOrderPositive(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'W+');
    }

    public function workOrderNegative(LegacyBitacoraEvent $event)
    {
        $this->createRegistry($event, 'W-');
    }

    /**
     * @param LegacyBitacoraEvent $event
     * @param $movementType
     *
     */
    public function createRegistry(LegacyBitacoraEvent $event, $movementType)
    {
        try {
            $resultSerial = true;
            $entity = $event->getEntityData();
            $nuevabitacora = New BitacoraAlmacen();

            switch (ClassUtils::getRealClass($entity)) {
                case 'Buseta\BodegaBundle\Entity\AlbaranLinea': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\AlbaranLinea */
                    $nuevabitacora
                        ->setAlmacen($entity->getAlmacen())
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida($entity->getCantidadMovida())
                        ->setFechaMovimiento($entity->getAlbaran()->getFechaMovimiento())
                        ->setEntradaSalidaLinea($entity)
                        ->setTipoMovimiento($movementType);

                    //desde aqui llamo el metodo guardarSerialesDesdeAlbaranLinea de la Bitacora de Seriales
                    if ($entity->getProducto()->getTieneNroSerie()) {
                        $resultSerial = $this->bitacoraSerialManager->guardarSerialesDesdeAlbaranLinea($entity,
                            $movementType);
                    }

                    break;
                }

                case 'Buseta\BodegaBundle\Entity\InventarioFisicoLinea': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\InventarioFisicoLinea */
                    $cantidadAMover = $entity->getCantidadReal() - $entity->getCantidadTeorica();
                    //establezco el tipo de movimiento
                    $nuevabitacora
                        ->setAlmacen($entity->getInventarioFisico()->getAlmacen())
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida(abs($cantidadAMover))//tomo el valor absoluto
                        ->setFechaMovimiento($entity->getInventarioFisico()->getFecha())
                        ->setInventarioLinea($entity)
                        ->setTipoMovimiento($cantidadAMover >= 0 ? 'I+' : 'I-');

                    //desde aqui llamo el metodo guardarSerialesDesdeInventarioFisicoLinea de la Bitacora de Seriales
                    if ($entity->getProducto()->getTieneNroSerie()) {
                        $resultSerial = $this->bitacoraSerialManager->guardarSerialesDesdeInventarioFisicoLinea($entity,
                            $movementType);

                    }



                    break;
                }

                case 'Buseta\BodegaBundle\Entity\MovimientosProductos': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\MovimientosProductos */

                    $nuevabitacora
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida($entity->getCantidad())
                        ->setFechaMovimiento($entity->getMovimiento()->getFechaMovimiento())
                        ->setMovimientoLinea($entity)
                        ->setTipoMovimiento($movementType);

                    if ($movementType === 'M-') {
                        $nuevabitacora->setAlmacen($entity->getMovimiento()->getAlmacenOrigen());
                    } elseif ($movementType == 'M+') {
                        $nuevabitacora->setAlmacen($entity->getMovimiento()->getAlmacenDestino());
                    } else {
                        throw new NotValidBitacoraTypeException('Tipo de Movimiento no valido' . $movementType);
                    }

                    //desde aqui llamo el metodo guardarSerialesDesdeMovimientoProducto de la Bitacora de Seriales
                    if ($entity->getProducto()->getTieneNroSerie()) {
                        $resultSerial = $this->bitacoraSerialManager->guardarSerialesDesdeMovimientoProducto($entity,
                            $movementType);
                    }

                    break;
                }

                case 'Buseta\BodegaBundle\Entity\SalidaBodegaProducto': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\SalidaBodegaProducto */
                    $nuevabitacora
                        //->setAlmacen($entity->getSalida()->get)
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida($entity->getCantidad())
                        ->setFechaMovimiento($entity->getSalida()->getFecha())
                        ->setProduccionLinea(sprintf('%s,%d', ClassUtils::getRealClass($entity), $entity->getId()))
                        ->setTipoMovimiento($movementType);

                    if ($movementType === 'M-') {
                        $nuevabitacora->setAlmacen($entity->getSalida()->getAlmacenOrigen());
                    } elseif ($movementType == 'M+') {
                        $nuevabitacora->setAlmacen($entity->getSalida()->getAlmacenDestino());
                    } else {
                        throw new NotValidBitacoraTypeException('Tipo de Salida de Producto no valido' . $movementType);
                    }

                    //desde aqui llamo el metodo guardarSerialesDesdeSalidaBodegaProducto de la Bitacora de Seriales
                    if ($entity->getProducto()->getTieneNroSerie()) {
                        $resultSerial = $this->bitacoraSerialManager->guardarSerialesDesdeSalidaBodegaProducto($entity,
                            $movementType);
                    }

                    break;
                }

                case 'Buseta\CombustibleBundle\Entity\ServicioCombustible': {
                    /* @var  $entity \Buseta\CombustibleBundle\Entity\ServicioCombustible */
                    $nuevabitacora
                        ->setAlmacen($entity->getCombustible()->getBodega())
                        ->setProducto($entity->getCombustible()->getProducto())
                        ->setCantidadMovida($entity->getCantidadLibros())
                        ->setFechaMovimiento($entity->getCreated())
                        ->setTipoMovimiento($movementType)
                        ->setProduccionLinea(sprintf('%s,%d', ClassUtils::getRealClass($entity), $entity->getId()));
                    break;
                }

                default:
                    break;
            }

            if ($resultSerial !== true) {
                //hubo error en la validacion de los seriales
                $event->setReturnValue($resultSerial);
            } else {

                //llego aqui si no hay error en los seriales
                //Si no hay error devuelve true, si hay error devuelve el codigo del error
                $result = $this->bitacoraAlmacenManager->createRegistry($nuevabitacora);
                $event->setReturnValue($result);
            }

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al crear la Bitacora de Almacen: %s', $e->getMessage()));
            $event->setReturnValue($error = 'Ha ocurrido un error al crear la Bitacora de Almacen');
        }

    }
}
