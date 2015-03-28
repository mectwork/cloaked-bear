<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\InventarioFisico;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Form\Type\InventarioFisicoLineaType;


class InventarioFisicoLineaHandler extends InventarioFisicoAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\InventarioFisico
     */
    private $inventariofisico;
    /**
     * @var \Buseta\BodegaBundle\Entity\InventarioFisicoLinea |null
     */
    private $inventariofisico_linea;

    public function bindData(InventarioFisico $inventariofisico, InventarioFisicoLinea $pedidoCompraLinea = null)
    {
        $this->inventariofisico      = $inventariofisico;
        $this->inventariofisico_linea  = $pedidoCompraLinea;

        if (!$this->inventariofisico_linea) {
            // Creando una nueva linea
            $this->inventariofisico_linea = new InventarioFisicoLinea();
            $this->inventariofisico_linea->setInventarioFisico($inventariofisico);

            $this->form = $this->formFactory->create(new InventarioFisicoLineaType(), $this->inventariofisico_linea, array(
                'method' => 'POST',
            ));
        } else {
            // Editando una Linea ya existente
            $this->form = $this->formFactory->create(new InventarioFisicoLineaType(), $this->inventariofisico_linea, array(
                'method' => 'PUT',
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
                $this->em->persist($this->inventariofisico_linea);
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