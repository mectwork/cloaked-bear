<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\BitacoraSerial;
use Buseta\BodegaBundle\Entity\ProductoSeriado;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator;
use Symfony\Bridge\Monolog\Logger;
use Buseta\BodegaBundle\Extras\GeneradorSeriales;

/**
 * Class BitacoraSerialManager
 * @package Buseta\BodegaBundle\Manager
 */
class BitacoraSerialManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var \Symfony\Component\Validator\Validator
     */
    private $validator;

    /**
     * @var \Buseta\BodegaBundle\Extras\GeneradorSeriales
     */
    private $generadorSeriales;


    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param Validator $validator
     * @param GeneradorSeriales $generadorSeriales
     */
    function __construct(ObjectManager $em, Logger $logger, Validator $validator, GeneradorSeriales $generadorSeriales)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->validator = $validator;
        $this->generadorSeriales = $generadorSeriales;
    }


    /**
     * @param $albaranLinea  \Buseta\BodegaBundle\Entity\AlbaranLinea
     * @param $movementType string
     * @return bool
     */
    public function guardarSerialesDesdeAlbaranLinea($albaranLinea, $movementType)
    {

        try {

            $ocurrioError = false;
            $error = '';

            $productoTieneNroSerie = $albaranLinea->getProducto()->getTieneNroSerie();
            $cantidadMovida = $albaranLinea->getCantidadMovida();

            $strSeriales = $albaranLinea->getSeriales();

            //cadena validacion
            if ($strSeriales !== null && trim($strSeriales) !== '') {

                $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                if ($seriales) {

                    $numeroSeriales = count($seriales);

                    //verificar si la cantidad movida coincide con el numero de seriales
                    if ($numeroSeriales != $cantidadMovida) {
                        $ocurrioError = true;
                        $error = 'La cantidad movida no coincide con el numero de seriales';
                    }

                    //Si llega aqui todo bien y no hay errores de validacion
                    foreach ($seriales as $serial) {
                        //para cada serial creo un producto seriado en la base de datos
                        //y luego creo una bitacora de serial

                        //en el albaran hay que crear los productos seriados
                        $productoSeriado = new ProductoSeriado();
                        $productoSeriado
                            ->setCantidad(1)
                            ->setNumeroSerie($serial)
                            ->setProducto($albaranLinea->getProducto());

                        $this->em->persist($productoSeriado);

                        //creo la bitacora de seriales
                        $bitacoraSerial = new BitacoraSerial();
                        $bitacoraSerial
                            ->setProducto($albaranLinea->getProducto())
                            ->setProductoSeriado($productoSeriado)
                            ->setCantidadMovida(1)
                            ->setSerial($serial)
                            ->setFechaMovimiento($albaranLinea->getAlbaran()->getFechaMovimiento())
                            ->setEntradaSalidaLinea($albaranLinea)
                            ->setAlmacen($albaranLinea->getAlbaran()->getAlmacen())
                            ->setTipoMovimiento($movementType);

                        //validacion y creacion de una linea  de bitacoraSerial
                        $this->createRegistry($bitacoraSerial);

                    }

                } else {
                    $ocurrioError = true;
                    $error = $this->generadorSeriales->getLasterror();
                }

            }

            if ($ocurrioError) {
                return false;
            }

            //si todo bien hasta aqui hago el flush, que es cuando de verdad se guarda en la Base de datos
            //todo s los seriales
            $this->em->flush();

        } catch (\Exception $e) {
            $this->logger->error(sprintf('BitacoraSerial.Persist: %s', $e->getMessage()));
            //hacer rollback en el futuro
            return false;
        }

    }



    /**
     * @param $inventarioFisicoLinea  \Buseta\BodegaBundle\Entity\InventarioFisicoLinea
     * @param $movementType string
     * @return bool
     */
    public function guardarSerialesDesdeInventarioFisicoLinea($inventarioFisicoLinea, $movementType)
    {

        try {

            $ocurrioError = false;
            $error = '';

            $productoTieneNroSerie = $inventarioFisicoLinea->getProducto()->getTieneNroSerie();
            $cantidadMovida = $inventarioFisicoLinea->getCantidadReal();

            $strSeriales = $inventarioFisicoLinea->getSeriales();

            //cadena validacion
            if ($strSeriales !== null && trim($strSeriales) !== '') {

                $seriales = $this->generadorSeriales->getListaDeSeriales($strSeriales);

                if ($seriales) {

                    $numeroSeriales = count($seriales);

                    //verificar si la cantidad movida coincide con el numero de seriales
                    if ($numeroSeriales != $cantidadMovida) {
                        $ocurrioError = true;
                        $error = 'La cantidad movida no coincide con el numero de seriales';
                    }

                    //Si llega aqui todo bien y no hay errores de validacion
                    foreach ($seriales as $serial) {
                        //para cada serial creo un producto seriado en la base de datos
                        //creo una bitacora de serial

                        //en el albaran hay que crear los productos seriados
                        $productoSeriado = new ProductoSeriado();
                        $productoSeriado
                            ->setCantidad(1)
                            ->setNumeroSerie($serial)
                            ->setProducto($inventarioFisicoLinea->getProducto());

                        $this->em->persist($productoSeriado);

                        //creo la bitacora de seriales
                        $bitacoraSerial = new BitacoraSerial();
                        $bitacoraSerial
                            ->setProducto($inventarioFisicoLinea->getProducto())
                            ->setProductoSeriado($productoSeriado)
                            ->setCantidadMovida(1)
                            ->setSerial($serial)
                            ->setFechaMovimiento($inventarioFisicoLinea->getInventarioFisico()->getFecha())
                            ->setInventarioLinea($inventarioFisicoLinea)
                            ->setAlmacen($inventarioFisicoLinea->getInventarioFisico()->getAlmacen())
                            ->setTipoMovimiento($movementType);

                        //validacion y creacion
                        $this->createRegistry($bitacoraSerial);

                    }

                } else {
                    $ocurrioError = true;
                    $error = $this->generadorSeriales->getLasterror();
                }

            }

            if ($ocurrioError) {
                //return false;
            }

            //si todo bien hasta aqui hago el flush, que es cuando de verdad se guarda en la Base de datos
            //todo s los seriales
            $this->em->flush();

        } catch (\Exception $e) {
            $this->logger->error(sprintf('BitacoraSerial.Persist: %s', $e->getMessage()));
            //hacer rollback en el futuro
            return false;
        }

    }

    /**
     * @param BitacoraSerial $bitacora
     * @return bool
     */
    public function createRegistry(BitacoraSerial $bitacora)
    {
        try {

            //el validator valida por los assert de la entity
            $validationOrigen = $this->validator->validate($bitacora);
            if ($validationOrigen->count() === 0) {
                $this->em->persist($bitacora);
            } else {
                $errors = '';
                foreach ($validationOrigen->getIterator() as $param => $error) {
                    $errors .= sprintf('%s: %s. ', $param, $error);
                }
                $this->logger->error(sprintf('BitacoraSeriales.Validation: %s', $errors));
                return false;
            }

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('BitacoraSeriales.Persist: %s', $e->getMessage()));
            //hacer rollback en el futuro
            return false;
        }

    }

}
