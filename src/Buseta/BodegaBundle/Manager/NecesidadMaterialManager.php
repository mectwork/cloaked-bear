<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\BusetaBodegaDocumentStatus;
use Buseta\BodegaBundle\BusetaBodegaEvents;
use Buseta\BodegaBundle\Entity\NecesidadMaterial;
use Buseta\BodegaBundle\Event\FilterNecesidadMaterialEvent;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Buseta\BodegaBundle\Form\Model\NecesidadMaterialModel;

/**
 * Class NecesidadMaterial
 *
 * @package Buseta\BodegaBundle\Manager
 */
class NecesidadMaterialManager extends AbstractBodegaManager
{
    /**
     * @param NecesidadMaterialModel $model
     *
     * @return bool|NecesidadMaterial
     */
    public function crear(NecesidadMaterialModel $model)
    {
        $error = false;
        $necesidadMaterial = new NecesidadMaterial();
        $necesidadMaterial->setNumeroReferencia($model->getNumeroReferencia());
        $necesidadMaterial->setObservaciones($model->getObservaciones());
        $necesidadMaterial->setFechaPedido($model->getFechaPedido());
        $necesidadMaterial->setImporteTotalLineas($model->getImporteTotalLineas());
        $necesidadMaterial->setImporteTotal($model->getImporteTotal());
        $necesidadMaterial->setImporteCompra($model->getImporteCompra());
        $necesidadMaterial->setImporteDescuento($model->getImporteDescuento());
        $necesidadMaterial->setImporteImpuesto($model->getImporteImpuesto());
        $necesidadMaterial->setTercero($model->getTercero());
        $necesidadMaterial->setAlmacen($model->getAlmacen());
        $necesidadMaterial->setFormaPago($model->getFormaPago());
        $necesidadMaterial->setCondicionesPago($model->getCondicionesPago());
        $necesidadMaterial->setMoneda($model->getMoneda());
        $necesidadMaterial->setDescuento($model->getDescuento());
        $necesidadMaterial->setImpuesto($model->getImpuesto());


        if ($model->getNumeroDocumento() !== null){
            $necesidadMaterial->setNumeroDocumento($model->getNumeroDocumento());
        }
        if ($model->getEstadoDocumento() !== null) {
            $necesidadMaterial->setEstadoDocumento($model->getEstadoDocumento());
        }
        if (!$model->getNecesidadMaterialLineas()->isEmpty()) {
            foreach ($model->getNecesidadMaterialLineas() as $lineas) {
                $necesidadMaterial->addNecesidadMaterialLinea($lineas);
            }
        }

        try {
            $this->beginTransaction();

            if ($this->dispatcher->hasListeners(BusetaBodegaEvents::NECESIDADMATERIAL_PRE_CREATE)) {
                $preCreateEvent = new FilterNecesidadMaterialEvent($necesidadMaterial);
                $this->dispatcher->dispatch(BusetaBodegaEvents::NECESIDADMATERIAL_PRE_CREATE, $preCreateEvent);

                if ($preCreateEvent->getError()) {
                    $error = $preCreateEvent->getError();
                }
            }

            if (!$error) {
                $this->em->persist($necesidadMaterial);
            }

            if (!$error && $this->dispatcher->hasListeners(BusetaBodegaEvents::NECESIDADMATERIAL_POST_CREATE)) {
                $postCreateEvent = new FilterNecesidadMaterialEvent($necesidadMaterial);
                $this->dispatcher->dispatch(BusetaBodegaEvents::NECESIDADMATERIAL_POST_CREATE, $postCreateEvent);

                if ($postCreateEvent->getError()) {
                    $error = $postCreateEvent->getError();
                }
            }

            if (!$error) {
                $this->em->flush();

                // Try and commit the transaction, aqui puede ocurrir un error
                $this->commitTransaction();

                return $necesidadMaterial;
            }

            $this->logger->warning(sprintf('Necesidad Material no fue creada debido a errores previos: %s', $error));
        } catch (\Exception $e) {
            $this->logger->error(
                sprintf(
                    'Ha ocurrido un error al crear Necesidad Material. Detalles: {message: %s, class: %s, line: %d}',
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
