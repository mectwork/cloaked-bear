<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Form\Filter\CondicionesPagoFilter;
use Buseta\TallerBundle\Form\Model\CondicionesPagoFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\TallerBundle\Entity\CondicionesPago;
use Buseta\TallerBundle\Form\Type\CondicionesPagoType;

/**
 * CondicionesPago controller.
 */
class CondicionesPagoController extends Controller
{
    /**
     * Lists all CondicionesPago entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new CondicionesPagoFilterModel();

        $form = $this->createForm(new CondicionesPagoFilter(), $filter, array(
            'action' => $this->generateUrl('condicionespago'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:CondicionesPago')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:CondicionesPago')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );


        return $this->render('BusetaTallerBundle:CondicionesPago:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }
    /**
     * Creates a new CondicionesPago entity.
     */
    public function createAction(Request $request)
    {
        $entity = new CondicionesPago();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('condicionespago_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:CondicionesPago:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CondicionesPago entity.
     *
     * @param CondicionesPago $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CondicionesPago $entity)
    {
        $form = $this->createForm(new CondicionesPagoType(), $entity, array(
            'action' => $this->generateUrl('condicionespago_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CondicionesPago entity.
     */
    public function newAction()
    {
        $entity = new CondicionesPago();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:CondicionesPago:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CondicionesPago entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:CondicionesPago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionesPago entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:CondicionesPago:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CondicionesPago entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:CondicionesPago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionesPago entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:CondicionesPago:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a CondicionesPago entity.
     *
     * @param CondicionesPago $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CondicionesPago $entity)
    {
        $form = $this->createForm(new CondicionesPagoType(), $entity, array(
            'action' => $this->generateUrl('condicionespago_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CondicionesPago entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:CondicionesPago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CondicionesPago entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('condicionespago_show', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:CondicionesPago:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CondicionesPago entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaTallerBundle:CondicionesPago')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CondicionesPago entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Ha sido eliminado satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('logger')->addCritical(
                    sprintf('Ha ocurrido un error eliminando una condición de pago. Detalles: %s',
                        $e->getMessage()
                    ));
            }
        }

        return $this->redirect($this->generateUrl('condicionespago'));
    }

    /**
     * Creates a form to delete a CondicionesPago entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('condicionespago_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
