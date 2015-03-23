<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\TareaAdicional;
use Buseta\TallerBundle\Form\Type\TareaAdicionalType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * TareaAdicional controller.
 */
class TareaAdicionalController extends Controller
{
    public function newModalAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $entity = new TareaAdicional();

        $mpreventivo_id = $request->query->get('mpreventivo_id');

        if ($mpreventivo_id !== null) {
            $mpreventivo = $em->getRepository('BusetaTallerBundle:MantenimientoPreventivo')->find($mpreventivo_id);

            if ($mpreventivo !== null) {
                $grupo = $em->getRepository('BusetaNomencladorBundle:Grupo')->find($mpreventivo->getGrupo());
                $subgrupo = $em->getRepository('BusetaNomencladorBundle:Subgrupo')->find($mpreventivo->getSubgrupo());
                $tarea = $em->getRepository('BusetaNomencladorBundle:Tarea')->find($mpreventivo->getTarea());
                $garantia = $tarea->getGarantia();

                $entity->setGrupo($grupo);
                $entity->setSubgrupo($subgrupo);
                $entity->setTarea($tarea);
                $entity->setGarantiaTarea($garantia);
            }
        }

        $form = $this->createForm(new TareaAdicionalType(), $entity, array(
            'method' => 'POST',
            'action' => $this->generateUrl('tareaadicional_new_modal'),
        ));

        return $this->render('@BusetaTaller/OrdenTrabajo/modal/modal_tarea_adicional.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all TareaAdicional entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaTallerBundle:TareaAdicional')->findAll();

        return $this->render('BusetaTallerBundle:TareaAdicional:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new TareaAdicional entity.
     */
    public function createAction(Request $request)
    {
        $entity = new TareaAdicional();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tareaadicional_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:TareaAdicional:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TareaAdicional entity.
     *
     * @param TareaAdicional $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TareaAdicional $entity)
    {
        $form = $this->createForm(new TareaAdicionalType(), $entity, array(
            'action' => $this->generateUrl('tareaadicional_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TareaAdicional entity.
     */
    public function newAction()
    {
        $entity = new TareaAdicional();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:TareaAdicional:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TareaAdicional entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaAdicional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaAdicional entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:TareaAdicional:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing TareaAdicional entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaAdicional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaAdicional entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:TareaAdicional:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a TareaAdicional entity.
     *
     * @param TareaAdicional $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TareaAdicional $entity)
    {
        $form = $this->createForm(new TareaAdicionalType(), $entity, array(
            'action' => $this->generateUrl('tareaadicional_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TareaAdicional entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaAdicional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaAdicional entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tareaadicional_edit', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:TareaAdicional:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TareaAdicional entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaTallerBundle:TareaAdicional')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TareaAdicional entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tareaadicional'));
    }

    /**
     * Creates a form to delete a TareaAdicional entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tareaadicional_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to create a Tarea Adicional entity.
     *
     * @param TareaAdicional $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateOrdenTrabajoForm(TareaAdicional $entity)
    {
        $form = $this->createForm(new TareaAdicionalType(), $entity, array(
            'action' => $this->generateUrl('tarea_adicional_orden_trabajo_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    public function create_orden_trabajoAction(Request $request)
    {
        $entity = new TareaAdicional();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }
}
