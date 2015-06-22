<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\PersonaContacto;
use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\BodegaBundle\Form\PersonaContactoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PersonaContacto controller.
 *
 * @Route("/personacontacto")
 */
class PersonaContactoController extends Controller
{

    /**
     * Lists all PersonaContacto entities.
     *
     * @Route("/{tercero}", name="personacontacto", options={"expose": true})
     *
     * @Method("GET")
     */
    public function indexAction($tercero, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('BusetaBodegaBundle:PersonaContacto')->findByTercero($tercero);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:PersonaContacto:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PersonaContacto entity.
     *
     * @Route("/create/{tercero}", name="personacontacto_create")
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     *
     * @Method("POST")
     */
    public function createAction(Tercero $tercero, Request $request)
    {
        $entity = new PersonaContacto();
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

        $renderView = $this->renderView('BusetaBodegaBundle:PersonaContacto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a PersonaContacto entity.
     *
     * @param PersonaContacto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PersonaContacto $entity)
    {
        $form = $this->createForm(new PersonaContactoType(), $entity, array(
            'action' => $this->generateUrl('personacontacto_create', array('tercero' => $entity->getTercero()->getId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new PersonaContacto entity.
     *
     * @Route("/new/{tercero}", name="personacontacto_new", methods={"GET", "POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newAction(Tercero $tercero)
    {
        $entity = new PersonaContacto();
        $entity->setTercero($tercero);

        $form   = $this->createCreateForm($entity);

        $renderView = $this->renderView('BusetaBodegaBundle:PersonaContacto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Finds and displays a PersonaContacto entity.
     *
     * @Route("/{id}", name="personacontacto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PersonaContacto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PersonaContacto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PersonaContacto entity.
     *
     * @Route("/{id}/edit", name="personacontacto_edit", options={"expose":true})
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('BusetaBodegaBundle:PersonaContacto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PersonaContacto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $renderView = $this->renderView('BusetaBodegaBundle:PersonaContacto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView), 202);
    }

    /**
    * Creates a form to edit a PersonaContacto entity.
    *
    * @param PersonaContacto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PersonaContacto $entity)
    {
        $form = $this->createForm(new PersonaContactoType(), $entity, array(
            'action' => $this->generateUrl('personacontacto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing PersonaContacto entity.
     *
     * @Route("/{id}", name="personacontacto_update")
     * @Method("PUT")
     * @Template("BusetaBodegaBundle:PersonaContacto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PersonaContacto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PersonaContacto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('personacontacto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a PersonaContacto entity.
     *
     * @param PersonaContacto $personaContacto
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/delete", name="terceros_personacontacto_delete", methods={"GET", "POST", "DELETE"}, options={"expose":true})
     */
    public function deleteAction(PersonaContacto $personaContacto, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($personaContacto->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($personaContacto);
                $em->flush();

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $trans->trans('messages.delete.success', array(), 'BusetaBodegaBundle'),
                    ), 202);
                }
                // faltaría forma tradicional
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'PersonaContacto'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
                // faltaría forma tradicional
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/PersonaContacto/delete_modal.html.twig', array(
            'entity' => $personaContacto,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return new Response($renderView);
    }

    /**
     * Creates a form to delete a PersonaContacto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('terceros_personacontacto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
    }
}
