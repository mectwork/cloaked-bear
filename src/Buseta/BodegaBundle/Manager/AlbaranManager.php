<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Event\AlbaranEvents;
use Buseta\BodegaBundle\Event\BitacoraAlbaranEvent;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Event\LegacyBitacoraEvent;
use Buseta\BodegaBundle\Event\FilterAlbaranEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\DBAL\Connections;

/**
 * Class AlbaranManager
 *
 * @package Buseta\BodegaBundle\Manager
 */
class AlbaranManager
{
    /**
     * Set if use or not persistent transactions
     *
     * @var boolean
     */
    const USE_TRANSACTIONS = true;

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
     * @param EventDispatcherInterface $dispatcher
     */
    function __construct(ObjectManager $em, Logger $logger, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
    }


    /**
     * @param $id
     * @return bool|string
     */
    public function procesar($id)
    {
        try {

            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                throw new NotFoundElementException('No se encontro la entidad Albaran.');
            }

            if ($albaran->getEstadoDocumento() !== 'BO') {
                $this->logger->error(sprintf('El estado %s del Albaran con id %d no se corresponde con el estado previo a procesado(PR).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                ));
                throw new NotValidStateException();
            }

            // Change state Borrador(BO) to Procesado(PR)
            $event = new FilterAlbaranEvent($albaran);
            $this->dispatcher->dispatch(AlbaranEvents::POS_PROCESS, $event);
            $result = $event->getReturnValue();
            if ($result !== true) {
                //borramos los cambios en el entity manager
                $this->em->clear();
                return $error = $result;
            }

            $this->em->flush();
            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Albaran: %s', $e->getMessage()));
            //borramos los cambios en el entity manager
            $this->em->clear();
            return 'Ha ocurrido un error al procesar el Albaran';
        }

    }

    public function completar(Albaran $albaran, $flush=true)
    {
        try {
            if (self::USE_TRANSACTIONS) {
                $this->em->getConnection()->beginTransaction();
            }

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::ALBARAN_PRE_COMPLETE)) {
                $preCompleteEvent = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(BusetaBodegaEvents::ALBARAN_PRE_COMPLETE, $preCompleteEvent);
            }

            $this->cambiarEstado($albaran, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_COMPLETE, false);

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::ALBARAN_POS_COMPLETE)) {
                $posCompleteEvent = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(BusetaBodegaEvents::ALBARAN_POS_COMPLETE, $posCompleteEvent);

                if ($posCompleteEvent->getError()) {
                    if (self::USE_TRANSACTIONS) {
                        $this->em->getConnection()->rollback();
                    }

                    return false;
                }
            }

            if ($flush) {
                $this->em->flush();
            }

            // Try and commit the transaction, aqui puede ocurrir un error
            if (self::USE_TRANSACTIONS) {
                $this->em->getConnection()->commit();
            }

            return true;
        } catch (\Exception $e) {
            $this->logger->critical(sprintf('Ha ocurrido un error al completar Albaran. Detalles: %s', $e->getMessage()));

            if (self::USE_TRANSACTIONS) {
                $this->em->getConnection()->rollback();
            }

            return false;
        }
    }

    /**
     * Completar Albaran
     *
     * @param integer $id
     * @return bool
     *
     * @deprecated
     */
    public function legacyCompletar($id)
    {
        /** @var \Buseta\BodegaBundle\Entity\Albaran $albaran */
        /** @var \Buseta\BodegaBundle\Entity\AlbaranLinea $lineas */

        // suspend auto-commit
        $this->em->getConnection()->beginTransaction();

        try {
            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                throw new NotFoundElementException('No se encontro la entidad Albaran.');
            }

            $albaranLineas = $albaran->getAlbaranLineas();
            if ($albaranLineas !== null && count($albaranLineas) > 0) {
                //entonces mando a crear los movimientos en la bitacora, producto a producto, a traves de eventos
                foreach ($albaranLineas as $linea) {
                    $event = new LegacyBitacoraEvent($linea);
                    $this->dispatcher->dispatch(BitacoraEvents::VENDOR_RECEIPTS, $event);
                    $result = $event->getReturnValue();
                    if ($result !== true) {
                        // Rollback the failed transaction attempt
                        $this->em->getConnection()->rollback();
                        return $error = $result;
                    }
                }

                // Change state to 'CO'
                $event = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(AlbaranEvents::POS_COMPLETE, $event);
                $result = $event->getReturnValue();
                if ($result !== true) {
                    // Rollback the failed transaction attempt
                    $this->em->getConnection()->rollback();
                    return $error = $result;
                }
            } else {
                // Rollback the failed transaction attempt
                $this->em->getConnection()->rollback();
                return $error = 'La Orden de Entrega debe tener al menos una linea';
            }

            //finalmente le damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales yel cambio de estado
            //es el unico flush que se hace.
            $this->em->flush();

            // Try and commit the transaction, aqui puede ocurrir un error
            $this->em->getConnection()->commit();

            return true;

        } catch (\Exception $e) {

            $this->logger->error(sprintf('Ha ocurrido un error al procesar la Orden de Entrega: %s',
                $e->getMessage()));

            // Rollback the failed transaction attempt
            $this->em->getConnection()->rollback();

            //$this->em->clear();
            return $error = 'Ha ocurrido un error al completar la Orden de Entrega';
        }

    }


    /**
     * Change Albaran document status
     *
     * @param Albaran $albaran
     * @param string $estado
     * @param boolean $flush
     *
     * @return bool|string
     */
    private function cambiarEstado(Albaran $albaran, $estado, $flush=true)
    {
        try {
            if (($albaran === null) || ($estado === null)) {
                return 'El albaran no puede ser vacio';
            }

            $albaran->setEstadoDocumento($estado);
            $this->em->persist($albaran);
            if ($flush) {
                $this->em->flush();
            }

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al cambiar estado al Albaran: %s', $e->getMessage()));

            return false;
        }
    }

    /**
     * Change Albaran document status
     *
     * @param Albaran $albaran
     * @param string $estado
     * @param boolean $flush
     *
     * @return bool|string
     *
     * @deprecated
     */
    public function legacyCambiarestado(Albaran $albaran, $estado, $flush=true)
    {
        try {
            if (($albaran === null) || ($estado === null)) {
                return 'El albaran no puede ser vacio';
            }

            $albaran->setEstadoDocumento($estado);
            $this->em->persist($albaran);
            if ($flush) {
                $this->em->flush();
            }

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al cambiar estado al Albaran: %s', $e->getMessage()));

            return false;
        }
    }
}
