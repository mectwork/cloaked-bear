<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Entity\PedidoCompra;
use Buseta\BodegaBundle\Event\FilterPedidoCompraEvent;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Buseta\BodegaBundle\Form\Model\PedidoCompraModel;

/**
 * Class PedidoCompra
 *
 * @package Buseta\BodegaBundle\Manager
 */
class PedidoCompraManager extends AbstractBodegaManager
{
    /**
     * @param PedidoCompraModel $model
     *
     * @return bool|PedidoCompra
     */
    public function crear(PedidoCompraModel $model)
    {
        $error = false;
        $pedidoCompra = new PedidoCompra();
        $pedidoCompra->setNumeroReferencia($model->getNumeroReferencia());
        $pedidoCompra->setObservaciones($model->getObservaciones());
        $pedidoCompra->setFechaPedido($model->getFechaPedido());
        $pedidoCompra->setImporteTotalLineas($model->getImporteTotalLineas());
        $pedidoCompra->setImporteTotal($model->getImporteTotal());
        $pedidoCompra->setImporteCompra($model->getImporteCompra());
        $pedidoCompra->setImporteDescuento($model->getImporteDescuento());
        $pedidoCompra->setImporteImpuesto($model->getImporteImpuesto());
        $pedidoCompra->setTercero($model->getTercero());
        $pedidoCompra->setAlmacen($model->getAlmacen());
        $pedidoCompra->setFormaPago($model->getFormaPago());
        $pedidoCompra->setCondicionesPago($model->getCondicionesPago());
        $pedidoCompra->setMoneda($model->getMoneda());
        $pedidoCompra->setDescuento($model->getDescuento());
        $pedidoCompra->setImpuesto($model->getImpuesto());


        if ($model->getNumeroDocumento() !== null){
            $pedidoCompra->setNumeroDocumento($model->getNumeroDocumento());
        }
        if ($model->getEstadoDocumento() !== null) {
            $pedidoCompra->setEstadoDocumento($model->getEstadoDocumento());
        }
        if (!$model->getPedidoCompraLineas()->isEmpty()) {
            foreach ($model->getPedidoCompraLineas() as $lineas) {
                $pedidoCompra->addPedidoCompraLinea($lineas);
            }
        }

        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::PEDIDOCOMPRA_PRE_CREATE)) {
                $preCreateEvent = new FilterPedidoCompraEvent($pedidoCompra);
                $this->dispatcher->dispatch(BusetaBodegaEvents::PEDIDOCOMPRA_PRE_CREATE, $preCreateEvent);

                if ($preCreateEvent->getError()) {
                    $error = $preCreateEvent->getError();
                }
            }

            if (!$error) {
                $this->em->persist($pedidoCompra);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::PEDIDOCOMPRA_POST_CREATE)) {
                $postCreateEvent = new FilterPedidoCompraEvent($pedidoCompra);
                $this->dispatcher->dispatch(BusetaBodegaEvents::PEDIDOCOMPRA_POST_CREATE, $postCreateEvent);

                if ($postCreateEvent->getError()) {
                    $error = $postCreateEvent->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                // Try and commit the transaction, aqui puede ocurrir un error
                $this->commitTransaction();

                return $pedidoCompra;
            }

            $this->logger->warning(sprintf('Pedido de Compra no fue creado debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf(
                    'Ha ocurrido un error al crear Pedido de Compra. Detalles: {message: %s, class: %s, line: %d}',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );
        }

        $this->rollbackTransaction();

        return false;
    }

}
