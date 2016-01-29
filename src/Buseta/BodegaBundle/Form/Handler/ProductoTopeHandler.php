<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\Bodega;
use Buseta\BodegaBundle\Entity\ProductoTope;
use Buseta\BodegaBundle\Form\Type\ProductoTopeType;

class ProductoTopeHandler extends BodegaAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $bodega;
    /**
     * @var \Buseta\BodegaBundle\Entity\ProductoTope |null
     */
    private $productoTope;

    public function bindData(Bodega $bodega, ProductoTope $productoTope = null)
    {
        $this->bodega         = $bodega;
        $this->productoTope   = $productoTope;

        if (!$this->productoTope) {
            // Creando una nueva linea
            $this->productoTope = new ProductoTope();
            $this->productoTope->setAlmacen($bodega);

            $this->form = $this->formFactory->create(new ProductoTopeType(), $this->productoTope, array(
                'method' => 'POST',
                'action' => $this->router->generate('productotope_new_modal', array('id' => $bodega->getId())),
            ));
        } else {
            // Editando una Linea ya existente
            $this->form = $this->formFactory->create(new ProductoTopeType(), $this->productoTope, array(
                'method' => 'PUT',
                'action' => $this->router->generate('productotope_edit_modal', array('id' => $productoTope->getId(), 'almacen' => $bodega->getId())),
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
                $this->em->persist($this->productoTope);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Productos Tope'), 'BusetaBodegaBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}
