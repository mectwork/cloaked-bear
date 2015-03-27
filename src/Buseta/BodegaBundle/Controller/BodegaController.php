<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Form\Filter\BodegaFilter;
use Buseta\BodegaBundle\Form\Model\BodegaFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\Bodega;
use Buseta\BodegaBundle\Form\Type\BodegaType;
use Buseta\BodegaBundle\Form\Filtro\BusquedaAlmacenType;
use Buseta\BodegaBundle\Extras\FuncionesExtras;

/**
 * Bodega controller.
 */
class BodegaController extends Controller
{
    /**
     * Module Bodega entiy.
     */
    public function principalAction()
    {
        return $this->render('BusetaBodegaBundle:Default:principal.html.twig');
    }

    /**
     * Lists all Bodega entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new BodegaFilterModel();

        $form = $this->createForm(new BodegaFilter(), $filter, array(
            'action' => $this->generateUrl('bodega'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Bodega')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Bodega')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaBodegaBundle:Bodega:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Bodega entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Bodega();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bodega_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Bodega:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Bodega entity.
     *
     * @param Bodega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Bodega $entity)
    {
        $form = $this->createForm(new BodegaType(), $entity, array(
            'action' => $this->generateUrl('bodega_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Bodega entity.
     */
    public function newAction()
    {
        $entity = new Bodega();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:Bodega:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bodega entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bodega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Bodega:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Bodega entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bodega entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Bodega:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Bodega entity.
     *
     * @param Bodega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Bodega $entity)
    {
        $form = $this->createForm(new BodegaType(), $entity, array(
            'action' => $this->generateUrl('bodega_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Bodega entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bodega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bodega_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Bodega:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Bodega entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bodega entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Ha sido eliminado satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('logger')->addCritical(
                    sprintf('Ha ocurrido un error eliminando una Bodega. Detalles: %s',
                        $e->getMessage()
                    ));
            }
        }

        return $this->redirect($this->generateUrl('bodega'));
    }

    /**
     * Creates a form to delete a Bodega entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bodega_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Updated automatically select All when change select Producto.
     */
    public function select_bodega_productos_allAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();

        //Obtengo el producto seleccionado
        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->findOneBy(array(
            'id' => $request->query->get('producto_id'),
        ));

        //Obtengo el almacen seleccionado
        $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->findOneBy(array(
            'id' => $request->query->get('almacen_id'),
        ));

        $funcionesExtras = new FuncionesExtras();
        $cantidadReal = $funcionesExtras->obtenerCantidaProductosAlmancen($producto, $almacen, $em);

        $json = array(
            'cantidadReal' => $cantidadReal,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }
}
