<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\TareaAdicional;
use Buseta\TallerBundle\Form\Type\TareaAdicionalType;
use Buseta\TallerBundle\Form\Type\TareaAdicionalModalType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\TallerBundle\Entity\OrdenTrabajo;
use Buseta\TallerBundle\Form\Type\OrdenTrabajoType;
/**
 * OrdenTrabajo controller.
 *
 */
class OrdenTrabajoController extends Controller
{

    /**
     * Lists all OrdenTrabajo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaTallerBundle:OrdenTrabajo')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            5,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaTallerBundle:OrdenTrabajo:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new OrdenTrabajo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new OrdenTrabajo();
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            try {
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()
                    ->add('success', 'Se ha creado la Orden de Trabajo de forma satisfactoria.');

                return $this->redirect($this->generateUrl('ordentrabajo_show', array('id' => $entity->getId())));
            } catch(\Exception $e) {
                $this->get('logger')
                    ->addCritical(sprintf('Ha ocurrido un error creando la Orden de Trabajo. Detalles: %s', $e->getMessage()));

                $this->get('session')->getFlashBag()
                    ->add('danger', 'Ha ocurrido un error creando la Orden de Trabajo.');
            }
        }

        return $this->render('BusetaTallerBundle:OrdenTrabajo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a OrdenTrabajo entity.
    *
    * @param OrdenTrabajo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(OrdenTrabajo $entity)
    {
        $form = $this->createForm(new OrdenTrabajoType(), $entity, array(
            'action' => $this->generateUrl('ordentrabajo_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new OrdenTrabajo entity.
     *
     */
    public function newAction()
    {
        $entity = new OrdenTrabajo();

        //$entity->addTareaAdicional(new TareaAdicional());

        $tarea_adicional = $this->createForm(new TareaAdicionalType());

        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:OrdenTrabajo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tarea_adicional'  => $tarea_adicional->createView(),
        ));
    }

    /**
     * Finds and displays a OrdenTrabajo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:OrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrdenTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:OrdenTrabajo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing OrdenTrabajo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:OrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrdenTrabajo entity.');
        }

        $tarea_adicional = $this->createForm(new TareaAdicionalType());

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:OrdenTrabajo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'tarea_adicional'       => $tarea_adicional->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a OrdenTrabajo entity.
    *
    * @param OrdenTrabajo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OrdenTrabajo $entity)
    {
        $form = $this->createForm(new OrdenTrabajoType(), $entity, array(
            'action' => $this->generateUrl('ordentrabajo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing OrdenTrabajo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:OrdenTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrdenTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ordentrabajo_show', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:OrdenTrabajo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a OrdenTrabajo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaTallerBundle:OrdenTrabajo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OrdenTrabajo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ordentrabajo'));
    }

    /**
     * Creates a form to delete a OrdenTrabajo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ordentrabajo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
