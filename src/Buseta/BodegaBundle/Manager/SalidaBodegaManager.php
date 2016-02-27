<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Event\FilterSalidaBodegaEvent;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Event\LegacyBitacoraEvent;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;
use Doctrine\DBAL\Connections;

/**
 * Class SalidaBodegaManager
 *
 * @package Buseta\BodegaBundle\Manager\SalidaBodega
 */
class SalidaBodegaManager extends AbstractBodegaManager
{
    /**
     * Procesar SalidaBodega
     *
     * @param SalidaBodega $salidaBodega
     *
     * @return bool
     */
    public function procesar(SalidaBodega $salidaBodega)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::WAREHOUSE_INOUT_PRE_PROCESS)) {
                $preProcess = new FilterSalidaBodegaEvent($salidaBodega);
                $this->dispatcher->dispatch(BusetaBodegaEvents::WAREHOUSE_INOUT_PRE_PROCESS, $preProcess);

                if ($preProcess->getError()) {
                    $error = $preProcess->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($salidaBodega, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::WAREHOUSE_INOUT_POST_PROCESS)) {
                $postProcess = new FilterSalidaBodegaEvent($salidaBodega);
                $this->dispatcher->dispatch(BusetaBodegaEvents::WAREHOUSE_INOUT_POST_PROCESS, $postProcess);
            }

            if (!$error) {
                $this->em->flush();

                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Salida Bodega no procesada debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->critical(
                sprintf(
                    'Ha ocurrido un error al procesar Salida Bodega. Detalles: {message: %s, class: %s, line: %d}',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );
        }

        $this->rollbackTransaction();

        return false;
    }


    /**
     * Completar SalidaBodega
     *
     * @param integer $id
     * @return bool
     */
    public function completar($id)
    {
        /** @var \Buseta\BodegaBundle\Entity\SalidaBodega $salidaBodega */
        /** @var \Buseta\BodegaBundle\Entity\SalidaBodegaProducto $linea */

        try {
            $salidaBodega = $this->em->getRepository('BusetaBodegaBundle:SalidaBodega')->find($id);
            if (!$salidaBodega) {
                throw new NotFoundElementException('Unable to find SalidaBodega entity.');
            }

            // suspend auto-commit
            $this->em->getConnection()->beginTransaction();

            $salidasBodega = $salidaBodega->getSalidasProductos();
            if ($salidasBodega !== null && count($salidasBodega) > 0) {
                //entonces mando a crear los movimientos en la bitacora, producto a producto, a traves de eventos
                foreach ($salidasBodega as $linea) {
                    $event = new LegacyBitacoraEvent($linea);
                    $this->event_dispacher->dispatch(BitacoraEvents::INTERNAL_CONSUMPTION_NEGATIVE /*I-*/, $event);
                    $result = $event->getReturnValue();
                    if (!$result) {
                        // Rollback the failed transaction attempt
                        $this->em->getConnection()->rollback();
                        return $error = $result;
                    }
                    //aunque debe ser de la siguiente forma
                    //$event = new LegacyBitacoraEvent($linea);
                    //$eventDispatcher->dispatch(BitacoraEvents::PRODUCTION_NEGATIVE, $event);//P+
                }

                //Cambia el estado de Procesado a Completado e incorpora otros datos
                $username = $this->tokenStorage->getToken()->getUser()->getUsername();
                //$salidaBodega->setCreatedBy($username);
                $salidaBodega->setMovidoBy($username);
                $salidaBodega->setFecha($fechaSalidaBodega = new \DateTime());
                $salidaBodega->setEstadoDocumento('CO');
                $this->em->persist($salidaBodega);

            } else {
                // Rollback the failed transaction attempt
                $this->em->getConnection()->rollback();

                return false;
            }

            //finalmentele damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales
            //es el unico flush que se hace.
            $this->em->flush();

            // Try and commit the transaction, aqui puede ocurrir un error
            $this->em->getConnection()->commit();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al completar la salida de bodega: %s',
                $e->getMessage()));

            // Rollback the failed transaction attempt
            $this->em->getConnection()->rollback();

            return false;
        }
    }

    /**
     * Change Salida Bodega document status
     *
     * @param SalidaBodega $albaran
     * @param string       $status
     * @param boolean      $error
     *
     * @return bool|string
     */
    private function cambiarEstado(SalidaBodega $albaran, $status, &$error)
    {
        try {
            $albaran->setEstadoDocumento($status);

            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $error = 'Ha ocurrido un error al cambiar estado de Salida Bodega.';
            $this->logger->critical(
                sprintf('%s. Detalles: %s', $error, $e->getMessage())
            );

            return false;
        }
    }
}
