<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Event\FilterInventarioFisicoEvent;
use Buseta\BodegaBundle\Entity\InventarioFisico;

/**
 * Class InventarioFisicoManager
 *
 * @package Buseta\BodegaBundle\Manager\InventarioFisicoManager
 */
class InventarioFisicoManager extends AbstractBodegaManager
{
    /**
     * Procesar InventarioFisico
     *
     * @param InventarioFisico $inventarioFisico
     *
     * @return bool
     */
    public function procesar(InventarioFisico $inventarioFisico)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_PROCESS)) {
                $preProcess = new FilterInventarioFisicoEvent($inventarioFisico);
                $this->dispatcher->dispatch(BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_PROCESS, $preProcess);

                if ($preProcess->getError()) {
                    $error = $preProcess->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($inventarioFisico, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_PROCESS, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_PROCESS)) {
                $posProcess = new FilterInventarioFisicoEvent($inventarioFisico);
                $this->dispatcher->dispatch(BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_PROCESS, $posProcess);

                if ($posProcess->getError()) {
                    $error = $posProcess->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                // Try and commit the transaction, aqui puede ocurrir un error
                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Inventario Físico no procesado debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf(
                    'Ha ocurrido un error al procesar Inventario Físico. Detalles: {message: %s, class: %s, line: %d}',
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
     * Completar InventarioFisico
     *
     * @param InventarioFisico $inventarioFisico
     *
     * @return bool
     */
    public function completar(InventarioFisico $inventarioFisico)
    {
        $error = false;
        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_COMPLETE)){
                $preComplete = new FilterInventarioFisicoEvent($inventarioFisico);
                $this->dispatcher->dispatch(BusetaBodegaEvents::PHYSICAL_INVENTORY_PRE_COMPLETE, $preComplete);

                if ($preComplete->getError()) {
                    $error = $preComplete->getError();
                }
            }

            if (!$error) {
                $this->cambiarEstado($inventarioFisico, BusetaBodegaDocumentStatus::DOCUMENT_STATUS_COMPLETE, $error);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_COMPLETE)) {
                $postComplete = new FilterInventarioFisicoEvent($inventarioFisico);
                $this->dispatcher->dispatch(BusetaBodegaEvents::PHYSICAL_INVENTORY_POST_COMPLETE, $postComplete);

                if ($postComplete->getError()) {
                    $error = $postComplete->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                $this->commitTransaction();

                return true;
            }

            $this->logger->warning(sprintf('Inventario Físico no completado debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf(
                    'Ha ocurrido un error al completar Inventario Físico. Detalles: {message: %s, class: %s, line: %d}',
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
     * CambiarEstado InventarioFisico
     *
     * @param InventarioFisico  $inventarioFisico
     * @param string            $estado
     * @param boolean|string    $error
     * @return bool
     */
    public function cambiarEstado(InventarioFisico $inventarioFisico, $estado, &$error)
    {
        try {
            /** @var \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico */
            $inventarioFisico->setEstado($estado);

            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al cambiar estado al Inventario Fisico. Detalles: %s',
                $e->getMessage()));

            $error = 'Ha ocurrido un error al cambiar estado al Inventario Fisico.';

            return false;
        }
    }
}
