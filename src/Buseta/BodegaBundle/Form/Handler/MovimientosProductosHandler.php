<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BodegaBundle\Form\Type\MovimientosProductosType;
use Buseta\BodegaBundle\Form\Type\MovimientoType;


class MovimientosProductosHandler extends MovimientosProductosAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\MovimientosProductos |null
     */
    private $movimiento_productos;

    public function bindData(Producto $producto = null)
    {
        $this->movimiento_productos  = $movimientosProductos;

        if (!$this->movimiento_productos) {
            // Creando una nuevo Movimiento de Productos
            /*$this->movimiento_productos = new MovimientosProductos();
            $this->movimiento_productos->setMovimiento($movimiento);*/

            $this->form = $this->formFactory->create(new MovimientoType(), $this->movimiento_productos, array(
                'method' => 'POST',
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
                var_dump("aaaaaaaaaaa");die;
                //$this->em->persist($this->movimiento_productos);
                //$this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->addCritical(sprintf(
                    $this->trans->trans('messages.update.error.%key%', array('key' => 'Movimientos de Productos'), 'BusetaBodegaBundle')
                    . ' Detalles: %s',
                    $e->getMessage()
                ));

                $this->error = true;
            }
        }

        return false;
    }
}