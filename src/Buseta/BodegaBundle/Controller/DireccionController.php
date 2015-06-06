<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Direccion;
use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\BodegaBundle\Form\Type\DireccionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Direccion controller.
 *
 * @Route("/direccion")
 */
class DireccionController extends Controller
{
    /**
     * Lists all Direccion entities.
     *
     * @Route("/{tercero}", name="direccion", options={"expose":true})
     *
     * @Method("GET")
     */
    public function indexAction($tercero, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('BusetaBodegaBundle:Direccion')->findByTercero($tercero);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:Direccion:index.html.twig', array(
            'entities' => $entities
        ));
    }
    /**
     * Creates a new Direccion entity.
     *
     * @Route("/create/{tercero}", name="direccion_create")
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     *
     * @Method("POST")
     */
    public function createAction(Tercero $tercero, Request $request)
    {
        $entity = new Direccion();
        $entity->setTercero($tercero);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $trans = $this->get('translator');

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            return new JsonResponse(array(
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle'),
            ), 201);
        }

        $renderView = $this->renderView('BusetaBodegaBundle:Direccion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a Direccion entity.
     *
     * @param Direccion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Direccion $entity)
    {
        $form = $this->createForm(new DireccionType(), $entity, array(
            'action' => $this->generateUrl('direccion_create', array('tercero' => $entity->getTercero()->getId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Direccion entity.
     *
     * @Route("/new/{tercero}", name="direccion_new", methods={"GET", "POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newAction(Tercero $tercero)
    {
        $entity = new Direccion();
        $entity->setTercero($tercero);

        $form   = $this->createCreateForm($entity);

        $renderView =  $this->renderView('BusetaBodegaBundle:Direccion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Finds and displays a Direccion entity.
     *
     * @Route("/{id}", name="direccion_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Direccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direccion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Direccion entity.
     *
     * @Route("/{id}/edit", name="direccion_edit", options={"expose":true})
     *
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Direccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direccion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $renderView = $this->renderView('BusetaBodegaBundle:Direccion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView), 202);
    }

    /**
     * Creates a form to edit a Direccion entity.
     *
     * @param Direccion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Direccion $entity)
    {
        $form = $this->createForm(new DireccionType(), $entity, array(
            'action' => $this->generateUrl('direccion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Direccion entity.
     *
     * @Route("/{id}", name="direccion_update")
     *
     * @Method("PUT")
     * @Template("BusetaBodegaBundle:Direccion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Direccion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direccion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('direccion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * @param Direccion $direccion
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/delete", name="terceros_direccion_delete", methods={"GET", "POST", "DELETE"}, options={"expose":true})
     */
    public function deleteAction(Direccion $direccion, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($direccion->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($direccion);
                $em->flush();

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $trans->trans('messages.delete.success', array(), 'BusetaBodegaBundle'),
                    ), 202);
                }
                // faltaría forma tradicional
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Dirección'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
                // faltaría forma tradicional
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/Direccion/delete_modal.html.twig', array(
            'entity' => $direccion,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return new Response($renderView);
    }

    /**
     * Creates a form to delete a Direccion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('terceros_direccion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
