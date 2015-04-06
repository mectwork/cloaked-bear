<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Form\Filter\MovimientosProductosFilter;
use Buseta\BodegaBundle\Form\Model\MovimientosProductosFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Form\Type\MovimientosProductosType;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class MovimientosProductosController
 * @package Buseta\BodegaBundle\Controller
 *
 * @Route("/movimientoproducto")
 */
class MovimientoProductosController extends Controller
{
    /**
     * @param MovimientosProductos $movimientoproducto
     * @return Response
     *
     * @Route("/list/{movimientoproducto}", name="movimientoproductos_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("movimientoproducto", options={"mapping":{"movimientoproducto":"id"}})
     */
    public function listAction(MovimientosProductos $movimientoproducto, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:MovimientosProductos')
            ->findAllByMovimientosProductosId($movimientoproducto->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                5
            );

        return $this->render('@BusetaBodega/Movimiento/MovimientosProductos/list_template.html.twig', array(
            'entities' => $entities,
            'movimientoproducto' => $movimientoproducto,
        ));
    }

    /**
     * @param Request $request
     *
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/movimientoproducto", name="movimientoproductos_new_modal", methods={"GET"}, options={"expose":true})
     */
    public function newModalAction(Request $request)
    {
        $filter = new MovimientosProductosFilterModel();

        $form = $this->createForm(new MovimientosProductosFilter(), $filter, array(
            'action' => $this->generateUrl('movimientoproductos_new_modal'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Producto')->filterProductos($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Producto')->findAll();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        $renderView = $this->renderView('@BusetaBodega/Movimiento/modal_form.html.twig', array(
            'form' => $form->createView(),
            'entities'      => $entities
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    public function obtenerProductoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($id);

        if (!$producto) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $json = array(
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Lists all MovimientosProductos entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:MovimientosProductos')->findAll();

        return $this->render('BusetaBodegaBundle:MovimientosProductos:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MovimientosProductos entity.
     */
    public function createAction(Request $request)
    {
        $entity = new MovimientosProductos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linea_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:MovimientosProductos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function create_compraAction(Request $request)
    {
        $entity = new MovimientosProductos();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Creates a form to create a MovimientosProductos entity.
     *
     * @param MovimientosProductos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MovimientosProductos $entity)
    {
        $form = $this->createForm(new MovimientosProductosType(), $entity, array(
            'action' => $this->generateUrl('linea_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a MovimientosProductos entity.
     *
     * @param MovimientosProductos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateCompraForm(MovimientosProductos $entity)
    {
        $form = $this->createForm(new MovimientosProductosType(), $entity, array(
                'action' => $this->generateUrl('linea_compra_create'),
                'method' => 'POST',
            ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MovimientosProductos entity.
     */
    public function newAction()
    {
        $entity = new MovimientosProductos();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:MovimientosProductos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MovimientosProductos entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MovimientosProductos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientosProductos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:MovimientosProductos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing MovimientosProductos entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MovimlineaientoProductoLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientosProductos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:MovimientosProductos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a MovimientosProductos entity.
     *
     * @param MovimientosProductos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(MovimientosProductos $entity)
    {
        $form = $this->createForm(new MovimientosProductosType(), $entity, array(
            'action' => $this->generateUrl('linea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MovimientosProductos entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MovimientosProductos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientosProductos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('linea_edit', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:MovimientosProductos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MovimientosProductosLina entity.
     *
     * @Route("/{id}/delete", name="movimiento_producto_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(MovimientosProductos $movimientoProducto, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($movimientoProducto->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($movimientoProducto);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Línea de Movimiento de Producto'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/MovimientosProductos/Linea/delete_modal.html.twig', array(
            'entity' => $movimientoProducto,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('movimientoproductos_list'));
    }

    /**
     * Creates a form to delete a MovimientosProductos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('linea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
