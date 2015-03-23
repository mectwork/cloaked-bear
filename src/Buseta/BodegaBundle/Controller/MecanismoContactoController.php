<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\MecanismoContacto;
use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\BodegaBundle\Form\Type\MecanismoContactoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/{tercero}", name="mecanismocontacto", options={"expose":true})
     *
     * @Method("GET")
     */
    public function indexAction($tercero, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('BusetaBodegaBundle:MecanismoContacto')->findByTercero($tercero);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:MecanismoContacto:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MecanismoContacto entity.
     *
     * @Route("/create/{tercero}", name="mecanismocontacto_create")
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     *
     * @Method("POST")
     */
    public function createAction(Tercero $tercero, Request $request)
    {
        $entity = new MecanismoContacto();
        $entity->setTercero($tercero);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $trans = $this->get('translator');

            $em->persist($entity);
            $em->flush();

            return new JsonResponse(array(
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle'),
            ), 201);
        }

        $renderView = $this->renderView('BusetaBodegaBundle:MecanismoContacto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
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
            'action' => $this->generateUrl('mecanismocontacto_create', array('tercero' => $entity->getTercero()->getId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new MecanismoContacto entity.
     *
     * @Route("/new/{tercero}", name="mecanismocontacto_new", methods={"GET", "POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newAction(Tercero $tercero)
    {
        $entity = new MecanismoContacto();
        $entity->setTercero($tercero);

        $form   = $this->createCreateForm($entity);

        $renderView = $this->renderView('BusetaBodegaBundle:MecanismoContacto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Finds and displays a MecanismoContacto entity.
     *
     * @Route("/{id}", name="mecanismocontacto_show")
     *
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
     * @Route("/{id}/edit", name="mecanismocontacto_edit", options={"expose":true})
     *
     * @Method("GET")
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

        $renderView = $this->renderView('BusetaBodegaBundle:MecanismoContacto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView), 202);
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

        return $form;
    }
    /**
     * Edits an existing MecanismoContacto entity.
     *
     * @Route("/{id}", name="mecanismocontacto_update")
     *
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
     *
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
            ->getForm()
            ;
    }
}
