<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BodegaBundle\Entity\PrecioProducto;
use Buseta\BodegaBundle\Form\Type\PrecioProductoType;

class PrecioProductoHandler extends ProductoAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     */
    private $producto;
    /**
     * @var \Buseta\BodegaBundle\Entity\PrecioProducto |null
     */
    private $precio_producto;

    public function bindData(Producto $producto, PrecioProducto $precioproducto = null)
    {
        $this->producto      = $producto;
        $this->precio_producto  = $precioproducto;

        if (!$this->precio_producto) {
            // Creando nuevo precio
            $this->precio_producto = new PrecioProducto();
            $this->precio_producto->setProducto($producto);

            $this->form = $this->formFactory->create(new PrecioProductoType(), $this->precio_producto, array(
                'method' => 'POST',
            ));
        } else {
            // Editando un precio ya existente
            $this->form = $this->formFactory->create(new PrecioProductoType(), $this->precio_producto, array(
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
                $this->em->persist($this->precio_producto);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Precio de Producto'), 'BusetaBodegaBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}