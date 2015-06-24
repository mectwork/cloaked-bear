<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\NecesidadMaterial;
use Buseta\BodegaBundle\Entity\NecesidadMaterialLinea;
use Buseta\BodegaBundle\Form\Type\NecesidadMaterialLineaType;


class NecesidadMaterialLineaHandler extends NecesidadMaterialAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\NecesidadMaterial
     */
    private $necesidadmaterial;
    /**
     * @var \Buseta\BodegaBundle\Entity\NecesidadMaterialLinea |null
     */
    private $necesidadmaterial_linea;

    public function bindData(NecesidadMaterial $necesidadmaterial, NecesidadMaterialLinea $necesidadMaterialLinea = null)
    {
        $this->necesidadmaterial         = $necesidadmaterial;
        $this->necesidadmaterial_linea   = $necesidadMaterialLinea;

        if (!$this->necesidadmaterial_linea) {
            // Creando una nueva linea
            $this->necesidadmaterial_linea = new NecesidadMaterialLinea();
            $this->necesidadmaterial_linea->setNecesidadMaterial($necesidadmaterial);

            $this->form = $this->formFactory->create(new NecesidadMaterialLineaType(), $this->necesidadmaterial_linea, array(
                'method' => 'POST',
                'action' => $this->router->generate('necesidadmaterial_lineas_new_modal', array('necesidadmaterial' => $necesidadmaterial->getId())),
            ));
        } else {
            // Editando una Linea ya existente
            $this->form = $this->formFactory->create(new NecesidadMaterialLineaType(), $this->necesidadmaterial_linea, array(
                'method' => 'PUT',
                'action' => $this->router->generate('necesidadmaterial_lineas_edit_modal', array('id' => $necesidadMaterialLinea->getId(), 'necesidadmaterial' => $necesidadmaterial->getId())),
            ));
        }
    }

    /**
     * @throws \Exception
     * @return boolean
     */
    public function handle()
    {
        if (!$this->request) {
            throw new \Exception('Debe definir el objeto Request en el Handler antes de ejecutar la acción.');
        }

        if(!$this->form) {
            throw new \Exception('Debe establecer los datos para el Handler con la función bindData.');
        }

        $this->form->handleRequest($this->request);
        if($this->form->isSubmitted() && $this->form->isValid()) {
            try {
                $this->em->persist($this->necesidadmaterial_linea);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Pedido Compra Líneas'), 'BusetaBodegaBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}
