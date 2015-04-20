<?php

namespace Buseta\BodegaBundle\Form\Handler;

use Buseta\BodegaBundle\Entity\PedidoCompra;
use Buseta\BodegaBundle\Entity\PedidoCompraLinea;
use Buseta\BodegaBundle\Form\Type\PedidoCompraLineaType;


class PedidoCompraLineaHandler extends PedidoCompraAbstractHandler
{
    /**
     * @var \Buseta\BodegaBundle\Entity\PedidoCompra
     */
    private $pedidocompra;
    /**
     * @var \Buseta\BodegaBundle\Entity\PedidoCompraLinea |null
     */
    private $pedidocompra_linea;

    public function bindData(PedidoCompra $pedidocompra, PedidoCompraLinea $pedidoCompraLinea = null)
    {
        $this->pedidocompra         = $pedidocompra;
        $this->pedidocompra_linea   = $pedidoCompraLinea;

        if (!$this->pedidocompra_linea) {
            // Creando una nueva linea
            $this->pedidocompra_linea = new PedidoCompraLinea();
            $this->pedidocompra_linea->setPedidoCompra($pedidocompra);

            $this->form = $this->formFactory->create(new PedidoCompraLineaType(), $this->pedidocompra_linea, array(
                'method' => 'POST',
                'action' => $this->router->generate('pedidocompra_lineas_new_modal', array('pedidocompra' => $pedidocompra->getId())),
            ));
        } else {
            // Editando una Linea ya existente
            $this->form = $this->formFactory->create(new PedidoCompraLineaType(), $this->pedidocompra_linea, array(
                'method' => 'PUT',
                'action' => $this->router->generate('pedidocompra_lineas_edit_modal', array('id' => $pedidoCompraLinea->getId(), 'pedidocompra' => $pedidocompra->getId())),
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
                $this->em->persist($this->pedidocompra_linea);
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
