<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BodegaBundle\Entity\CostoProducto;
use Buseta\BodegaBundle\Form\Type\CostoProductoType;

class CostoProductoHandler extends ProductoAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     */
    private $producto;
    /**
     * @var \Buseta\BodegaBundle\Entity\CostoProducto |null
     */
    private $costoProducto;

    public function bindData(Producto $producto, CostoProducto $costoProducto = null)
    {
        $this->producto      = $producto;
        $this->costoProducto = $costoProducto;

        if (!$this->costoProducto) {
            // Creando nuevo costo
            $this->costoProducto = new CostoProducto();
            $this->costoProducto->setProducto($producto);

            $this->form = $this->formFactory->create(new CostoProductoType(), $this->costoProducto, array(
                'method' => 'POST',
                'action' => $this->router->generate('producto_costos_new_modal', array(
                    'producto'  => $producto->getId(),
                )),
            ));
        } else {
            // Editando un costo ya existente
            $this->form = $this->formFactory->create(new CostoProductoType(), $this->costoProducto, array(
                'method' => 'PUT',
                'action' => $this->router->generate('producto_costos_edit_modal', array(
                    'id'        => $costoProducto->getId(),
                    'producto'  => $producto->getId(),
                )),
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
                $this->em->persist($this->costoProducto);
                $this->em->flush();

                return $this->costoProducto;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Costo de Producto'), 'BusetaBodegaBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}
