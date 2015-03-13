<?php

namespace Buseta\BodegaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\CategoriaProducto;
use Buseta\BodegaBundle\Form\Type\CategoriaProductoType;

/**
 * CategoriaProducto controller.
 */
class CategoriaProductoController extends Controller
{
    /**
     * Lists all CategoriaProducto entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaBodegaBundle:CategoriaProducto:index.html.twig', array(
                'entities' => $entities,
            ));
    }
    /**
     * Creates a new CategoriaProducto entity.
     */
    public function createAction(Request $request)
    {
        $entity = new CategoriaProducto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_producto_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:CategoriaProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CategoriaProducto entity.
     *
     * @param CategoriaProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CategoriaProducto $entity)
    {
        $form = $this->createForm(new CategoriaProductoType(), $entity, array(
            'action' => $this->generateUrl('categoria_producto_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CategoriaProducto entity.
     */
    public function newAction()
    {
        $entity = new CategoriaProducto();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:CategoriaProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoriaProducto entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:CategoriaProducto:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CategoriaProducto entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaProducto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:CategoriaProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a CategoriaProducto entity.
     *
     * @param CategoriaProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CategoriaProducto $entity)
    {
        $form = $this->createForm(new CategoriaProductoType(), $entity, array(
            'action' => $this->generateUrl('categoria_producto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CategoriaProducto entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_producto_show', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:CategoriaProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CategoriaProducto entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoriaProducto entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Ha sido eliminado satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('logger')->addCritical(
                    sprintf('Ha ocurrido un error eliminando un CategoriaProducto. Detalles: %s',
                        $e->getMessage()
                    ));
            }
        }

        return $this->redirect($this->generateUrl('categoria_producto'));
    }

    /**
     * Creates a form to delete a CategoriaProducto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_producto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
