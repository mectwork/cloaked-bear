<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Event\FilterInventarioFisicoEvent;
use Buseta\BodegaBundle\Event\InventarioFisicoEvents;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Buseta\BodegaBundle\Entity\InventarioFisico;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\DBAL\Connections;

/**
 * Class InventarioFisicoManager
 * @package Buseta\BodegaBundle\Manager\InventarioFisicoManager
 */
class InventarioFisicoManager
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
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     *
     */
    function __construct(ObjectManager $em, Logger $logger, $dispatcher)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Procesar InventarioFisico
     *
     * @param integer $id
     * @return bool
     * @throws NotValidStateException
     */
    public function procesar($id)
    {

        try {

            $inventarioFisico = $this->em->getRepository('BusetaBodegaBundle:InventarioFisico')->find($id);

            if (!$inventarioFisico) {
                throw new NotFoundElementException('No se encontro la entidad InventarioFisico.');
            }

            if ($inventarioFisico->getEstado() !== 'BO') {
                $this->logger->error(sprintf('El estado %s del Inventario Fisico con id %d no se corresponde con el estado previo a procesado(BO).',
                    $inventarioFisico->getEstado(),
                    $inventarioFisico->getId()
                ));
                throw new NotValidStateException();
            }

            // Change state Borrador(BO) to Procesado(PR)
            $event = new FilterInventarioFisicoEvent($inventarioFisico);
            $this->dispatcher->dispatch(InventarioFisicoEvents::POS_PROCESS, $event);
            $result = $event->getReturnValue();
            if ($result !== true) {
                //borramos los cambios en el entity manager
                $this->em->clear();
                return $error = $result;
            }

            $this->em->flush();
            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Inventario Fisico: %s',
                $e->getMessage()));
            $this->em->clear();
            return $error = 'Ha ocurrido un error al procesar el Inventario Fisico';
        }

    }


    /**
     * Completar InventarioFisico
     *
     * @param integer $id
     * @return bool
     */
    public function completar($id)
    {
        /** @var \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico */
        /** @var \Buseta\BodegaBundle\Entity\InventarioFisicoLinea $linea */

        // suspend auto-commit
        $this->em->getConnection()->beginTransaction();

        try {

            $inventarioFisico = $this->em->getRepository('BusetaBodegaBundle:InventarioFisico')->find($id);

            if (!$inventarioFisico) {
                throw new NotFoundElementException('No se encontro la entidad InventarioFisico.');
            }

            $inventarioFisicoLineas = $inventarioFisico->getInventarioFisicoLineas();

            if ($inventarioFisicoLineas !== null && count($inventarioFisicoLineas) > 0) {
                //entonces mando a crear los movimientos en la bitacora, producto a producto, a traves de eventos
                foreach ($inventarioFisicoLineas as $linea) {
                    $event = new FilterBitacoraEvent($linea);
                    $this->dispatcher->dispatch(BitacoraEvents::INVENTORY_IN, $event);//I+
                    $result = $event->getReturnValue();
                    if ($result !== true) {
                        // Rollback the failed transaction attempt
                        $this->em->getConnection()->rollback();
                        return $error = $result;
                    }
                }

                // Change state to 'CO'
                $event = new FilterInventarioFisicoEvent($inventarioFisico);
                $this->dispatcher->dispatch(InventarioFisicoEvents::POS_COMPLETE, $event);
                $result = $event->getReturnValue();
                if ($result !== true) {
                    // Rollback the failed transaction attempt
                    $this->em->getConnection()->rollback();
                    return $error = $result;
                }

            } else {
                // Rollback the failed transaction attempt
                $this->em->getConnection()->rollback();
                return $error = 'El inventario fisico debe tener al menos una linea';
            }

            //finalmente le damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales yel cambio de estado
            //es el unico flush que se hace.
            $this->em->flush();

            // Try and commit the transaction, aqui puede ocurrir un error
            $this->em->getConnection()->commit();

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Inventario Fisico: %s',
                $e->getMessage()));
            // Rollback the failed transaction attempt
            $this->em->getConnection()->rollback();
            return $error = 'Ha ocurrido un error al completar Inventario Fisico';
        }

    }


    /**
     * CambiarEstado InventarioFisico
     *
     * @param InventarioFisico $inventarioFisico
     * @param string $estado
     * @return bool
     */
    public function cambiarestado($inventarioFisico, $estado)
    {
        try {

            if (($inventarioFisico == null) || ($estado == null)) {
                return false;
            }

            /** @var \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico */
            $inventarioFisico->setEstado($estado);
            $this->em->persist($inventarioFisico);

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al cambiar estado al Inventario Fisico: %s',
                $e->getMessage()));
            return false;
        }

    }

}
