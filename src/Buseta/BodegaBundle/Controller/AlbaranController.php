<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\InformeProductosBodega;
use Buseta\BodegaBundle\Entity\InformeStock;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Form\Type\AlbaranLineaType;
use Buseta\BodegaBundle\Form\Type\PedidoCompraLineaType;
use Buseta\BodegaBundle\Form\Type\PedidoCompraType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Form\Type\AlbaranType;

/**
 * Albaran controller.
 *
 */
class AlbaranController extends Controller
{

    /**
     * Displays a form to edit an existing Albaran entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PedidoCompra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoCompra entity.');
        }

        $linea = $this->createForm(new PedidoCompraLineaType());

        $editForm = $this->createEditForm($entity);

        $em = $this->getDoctrine()->getManager();

        return $this->render('BusetaBodegaBundle:Albaran:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'linea'       => $linea->createView(),
        ));
    }

    /**
     * Creates a form to edit a PedidoCompra entity.
     *
     * @param PedidoCompra $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(PedidoCompra $entity)
    {
        $form = $this->createForm('bodega_pedido_compra',$entity, array(
            'action' => $this->generateUrl('pedidocompra_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Albaran entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Albaran entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pedidocompra_show', array('id' => $id)));
        }

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $json = array();

        foreach($productos as $p){

            $json[$p->getId()] = array(
                'nombre' => $p->getNombre(),
                'precio_salida' => $p->getPrecioSalida(),
            );
        }

        return $this->render('BusetaBodegaBundle:Albaran:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'json'   => json_encode($json),
        ));
    }

}
