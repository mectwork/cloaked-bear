<?php

namespace Buseta\BodegaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Buseta\BodegaBundle\Entity\MecanismoContacto;
use Buseta\BodegaBundle\Form\MecanismoContactoType;

/**
 * MecanismoContacto controller.
 *
 * @Route("/mecanismocontacto")
 */
class MecanismoContactoController extends Controller
{

    /**
     * Lists all MecanismoContacto entities.
     *
     * @Route("/", name="mecanismocontacto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:MecanismoContacto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MecanismoContacto entity.
     *
     * @Route("/", name="mecanismocontacto_create")
     * @Method("POST")
     * @Template("BusetaBodegaBundle:MecanismoContacto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new MecanismoContacto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mecanismocontacto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MecanismoContacto entity.
     *
     * @param MecanismoContacto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MecanismoContacto $entity)
    {
        $form = $this->createForm(new MecanismoContactoType(), $entity, array(
            'action' => $this->generateUrl('mecanismocontacto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MecanismoContacto entity.
     *
     * @Route("/new", name="mecanismocontacto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new MecanismoContacto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MecanismoContacto entity.
     *
     * @Route("/{id}", name="mecanismocontacto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MecanismoContacto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MecanismoContacto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MecanismoContacto entity.
     *
     * @Route("/{id}/edit", name="mecanismocontacto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MecanismoContacto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MecanismoContacto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a MecanismoContacto entity.
    *
    * @param MecanismoContacto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MecanismoContacto $entity)
    {
        $form = $this->createForm(new MecanismoContactoType(), $entity, array(
            'action' => $this->generateUrl('mecanismocontacto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MecanismoContacto entity.
     *
     * @Route("/{id}", name="mecanismocontacto_update")
     * @Method("PUT")
     * @Template("BusetaBodegaBundle:MecanismoContacto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MecanismoContacto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MecanismoContacto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mecanismocontacto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MecanismoContacto entity.
     *
     * @Route("/{id}", name="mecanismocontacto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:MecanismoContacto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MecanismoContacto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mecanismocontacto'));
    }

    /**
     * Creates a form to delete a MecanismoContacto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mecanismocontacto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
