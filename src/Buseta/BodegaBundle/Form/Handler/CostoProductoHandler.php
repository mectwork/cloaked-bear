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
    private $costo_producto;

    public function bindData(Producto $producto, CostoProducto $costoproducto = null)
    {
        $this->producto      = $producto;
        $this->costo_producto  = $costoproducto;

        if (!$this->costo_producto) {
            // Creando nuevo costo
            $this->costo_producto = new CostoProducto();
            $this->costo_producto->setProducto($producto);

            $this->form = $this->formFactory->create(new CostoProductoType(), $this->costo_producto, array(
                'method' => 'POST',
            ));
        } else {
            // Editando un costo ya existente
            $this->form = $this->formFactory->create(new CostoProductoType(), $this->costo_producto, array(
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

                //Comprobar si el Costo actual esta activo
                if($this->costo_producto->getActivo()) {
                    $costoProductoActivo = $this->em->getRepository('BusetaBodegaBundle:CostoProducto')->findOneBy(array(
                        'producto' => $this->costo_producto->getProducto(),
                        'activo' => true
                    ));

                    //Si existe el CostoProducto activo entonces se desactiva
                    if($costoProductoActivo != null) {
                        $costoProductoActivo->setActivo(false);
                        $this->em->persist($costoProductoActivo);
                        $this->em->flush();
                    }
                }
                elseif(!$this->costo_producto->getActivo()) {
                    $costoProductoActivo = $this->em->getRepository('BusetaBodegaBundle:CostoProducto')->findOneBy(array(
                        'producto' => $this->costo_producto->getProducto(),
                        'activo' => true
                    ));

                    //Si NO existe el CostoProducto activo entonces se activa automatica el nuevo CostoProducto
                    if($costoProductoActivo == null) {
                        $this->costo_producto->setActivo(true);
                    }
                }
                
                $this->em->persist($this->costo_producto);
                $this->em->flush();

                return true;
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