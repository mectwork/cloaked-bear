<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\FilterSalidaBodegaEvent;
use Buseta\BodegaBundle\Entity\SalidaBodega;

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
     * @param SalidaBodega $salidaBodega
     *
     * @return bool
     */
    public function completar(SalidaBodega $salidaBodega)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::WAREHOUSE_INOUT_PRE_COMPLETE)) {
                $preComplete = new FilterSalidaBodegaEvent($salidaBodega);
                $this->dispatcher->dispatch(BusetaBodegaEvents::WAREHOUSE_INOUT_PRE_COMPLETE, $preComplete);

                if ($preComplete->getError()) {
                    $error = $preComplete->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($salidaBodega, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_COMPLETE, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::WAREHOUSE_INOUT_POST_COMPLETE)) {
                $postComplete = new FilterSalidaBodegaEvent($salidaBodega);
                $this->dispatcher->dispatch(BusetaBodegaEvents::WAREHOUSE_INOUT_POST_COMPLETE, $postComplete);

                if ($postComplete->getError()) {
                    $error = $postComplete->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Salida Bodega no completada debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->critical(
                sprintf(
                    'Ha ocurrido un error al completar Salida Bodega. Detalles: {message: %s, class: %s, line: %d}',
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
