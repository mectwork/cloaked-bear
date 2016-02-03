<?php

namespace Buseta\TallerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\TallerBundle\Entity\TareaDiagnostico;
use Buseta\TallerBundle\Form\Type\TareaDiagnosticoType;

/**
 * TareaDiagnostico controller.
 *
 */
class TareaDiagnosticoController extends Controller
{


    public function newModalAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $entity = new TareaDiagnostico();

        $mpreventivo_id = $request->query->get('mpreventivo_id');

        if ($mpreventivo_id !== null) {
            $mpreventivo = $em->getRepository('BusetaTallerBundle:MantenimientoPreventivo')->find($mpreventivo_id);

            if ($mpreventivo !== null) {
                $grupo = $em->getRepository('BusetaNomencladorBundle:Grupo')->find($mpreventivo->getGrupo());
                $subgrupo = $em->getRepository('BusetaNomencladorBundle:Subgrupo')->find($mpreventivo->getSubgrupo());
                $tarea = $em->getRepository('BusetaNomencladorBundle:Tarea')->find($mpreventivo->getTarea());


                $entity->setGrupo($grupo);
                $entity->setSubgrupo($subgrupo);
                $entity->setTarea($tarea);

            }
        }

        $form = $this->createForm(new TareaDiagnosticoType(), $entity, array(
            'method' => 'POST',
            'action' => $this->generateUrl('tareadiagnostico_new_modal'),
        ));

        return $this->render('@BusetaTaller/Diagnostico/modal/modal_tarea_diagnostico.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all TareaDiagnostico entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaTallerBundle:TareaDiagnostico')->findAll();

        return $this->render('BusetaTallerBundle:TareaDiagnostico:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TareaDiagnostico entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TareaDiagnostico();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tareadiagnostico_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:TareaDiagnostico:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TareaDiagnostico entity.
     *
     * @param TareaDiagnostico $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TareaDiagnostico $entity)
    {
        $form = $this->createForm(new TareaDiagnosticoType(), $entity, array(
            'action' => $this->generateUrl('tareadiagnostico_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TareaDiagnostico entity.
     *
     */
    public function newAction()
    {
        $entity = new TareaDiagnostico();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:TareaDiagnostico:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TareaDiagnostico entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaDiagnostico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaDiagnostico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:TareaDiagnostico:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TareaDiagnostico entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaDiagnostico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaDiagnostico entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:TareaDiagnostico:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TareaDiagnostico entity.
    *
    * @param TareaDiagnostico $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TareaDiagnostico $entity)
    {
        $form = $this->createForm(new TareaDiagnosticoType(), $entity, array(
            'action' => $this->generateUrl('tareadiagnostico_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TareaDiagnostico entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaDiagnostico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaDiagnostico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tareadiagnostico_edit', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:TareaDiagnostico:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TareaDiagnostico entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaTallerBundle:TareaDiagnostico')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TareaDiagnostico entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tareadiagnostico'));
    }

    /**
     * Creates a form to delete a TareaDiagnostico entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tareadiagnostico_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

}
