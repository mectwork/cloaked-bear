<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Event\FilterMovimientoEvent;

/**
 * Class AlbaranManager
 *
 * @package Buseta\BodegaBundle\Manager
 */
class MovimientoManager extends AbstractBodegaManager
{
    /**
     * Procesar Movimiento
     *
     * @param Movimiento $movimiento
     *
     * @return bool
     */
    public function procesar(Movimiento $movimiento)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::MOVEMENT_PRE_PROCESS)) {
                $preProcess = new FilterMovimientoEvent($movimiento);
                $this->dispatcher->dispatch(BusetaBodegaEvents::MOVEMENT_PRE_PROCESS, $preProcess);

                if ($preProcess->getError()) {
                    $error = $preProcess->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($movimiento, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::MOVEMENT_POST_PROCESS)) {
                $postProcess = new FilterMovimientoEvent($movimiento);
                $this->dispatcher->dispatch(BusetaBodegaEvents::MOVEMENT_POST_PROCESS, $postProcess);

                if ($postProcess->getError()) {
                    $error = $postProcess->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                // Try and commit the transaction, aqui puede ocurrir un error
                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Movimiento no procesado debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf(
                    'Ha ocurrido un error al procesar Movimiento. Detalles: {message: %s, class: %s, line: %d}',
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
     * Completar Movimiento
     *
     * @param Movimiento $movimiento
     *
     * @return bool
     */
    public function completar(Movimiento $movimiento)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::MOVEMENT_PRE_COMPLETE)) {
                $preComplete = new FilterMovimientoEvent($movimiento);
                $this->dispatcher->dispatch(BusetaBodegaEvents::MOVEMENT_PRE_COMPLETE, $preComplete);

                if ($preComplete->getError()) {
                    $error = $preComplete->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($movimiento, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_COMPLETE, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::MOVEMENT_POST_COMPLETE)) {
                $postComplete = new FilterMovimientoEvent($movimiento);
                $this->dispatcher->dispatch(BusetaBodegaEvents::MOVEMENT_POST_COMPLETE, $postComplete);

                if ($postComplete->getError()) {
                    $error = $postComplete->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                // Try and commit the transaction, aqui puede ocurrir un error
                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Movimiento no procesado debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->critical(
                sprintf(
                    'Ha ocurrido un error al completar Orden de Entrada. Detalles: {message: %s, class: %s, line: %d}',
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
     * @param Movimiento $movimiento
     * @param            $estado
     * @param            $error
     *
     * @return bool
     */
    private function cambiarEstado(Movimiento $movimiento, $estado, &$error)
    {
        try {
            $movimiento->setEstadoDocumento($estado);
            //$this->em->persist($albaran);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->critical(
                sprintf('Ha ocurrido un error al cambiar estado de Movimiento. Detalles: %s', $e->getMessage())
            );

            $error = 'Ha ocurrido un error al cambiar estado de Movimiento.';

            return false;
        }
    }
}
