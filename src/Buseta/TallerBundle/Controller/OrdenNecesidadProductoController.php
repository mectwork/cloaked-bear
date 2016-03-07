<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\OrdenNecesidadProducto;
use Buseta\TallerBundle\Entity\OrdenTrabajo;
use Buseta\TallerBundle\Form\Type\OrdenNecesidadProductoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * OrdenNecesidadProducto controller.
 *
 * @Route("/ordennecesidadproducto")
 */
class OrdenNecesidadProductoController extends Controller
{
    /**
     * Lists all OrdenNecesidadProducto entities.
     *
     * @Route("/{ordentrabajo}", name="ordennecesidadproducto", options={"expose":true})
     *
     * @Method("GET")
     */
    public function indexAction(OrdenTrabajo $ordentrabajo, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('BusetaTallerBundle:OrdenNecesidadProducto')->findByOrdentrabajo($ordentrabajo);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaTallerBundle:OrdenNecesidadProducto:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new OrdenNecesidadProducto entity.
     *
     * @Route("/create/{ordentrabajo}", name="ordennecesidadproducto_create")
     * @ParamConverter("ordentrabajo", options={"mapping":{"ordentrabajo":"id"}})
     *
     * @Method("POST")
     */
    public function createAction(OrdenTrabajo $ordentrabajo, Request $request)
    {
        $entity = new OrdenNecesidadProducto();
        $entity->setOrdentrabajo($ordentrabajo);

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $trans = $this->get('translator');

            $em->persist($entity);
            $em->flush();

            return new JsonResponse(array(
                'message' => $trans->trans('messages.create.success', array(), 'BusetaTallerBundle'),
            ), 201);
        }

        $renderView = $this->renderView('BusetaTallerBundle:OrdenNecesidadProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a OrdenNecesidadProducto entity.
     *
     * @param OrdenNecesidadProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OrdenNecesidadProducto $entity)
    {
        $form = $this->createForm(new OrdenNecesidadProductoType(), $entity, array(
            'action' => $this->generateUrl('ordennecesidadproducto_create', array('ordentrabajo' => $entity->getOrdentrabajo()->getId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new OrdenNecesidadProducto entity.
     *
     * @Route("/new/{ordentrabajo}", name="ordennecesidadproducto_new", methods={"GET", "POST"}, options={"expose":true})
     * @ParamConverter("ordentrabajo", options={"mapping":{"ordentrabajo":"id"}})
     */
    public function newAction(OrdenTrabajo $ordentrabajo)
    {
        $entity = new OrdenNecesidadProducto();
        $entity->setOrdentrabajo($ordentrabajo);

        $form   = $this->createCreateForm($entity);

        $renderView = $this->renderView('BusetaTallerBundle:OrdenNecesidadProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Finds and displays a OrdenNecesidadProducto entity.
     *
     * @Route("/{id}", name="ordennecesidadproducto_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:OrdenNecesidadProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrdenNecesidadProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OrdenNecesidadProducto entity.
     *
     * @Route("/{id}/edit", name="ordennecesidadproducto_edit", options={"expose":true})
     *
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:OrdenNecesidadProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrdenNecesidadProducto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $renderView = $this->renderView('BusetaTallerBundle:OrdenNecesidadProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView), 202);
    }

    /**
     * Creates a form to edit a OrdenNecesidadProducto entity.
     *
     * @param OrdenNecesidadProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(OrdenNecesidadProducto $entity)
    {
        $form = $this->createForm(new OrdenNecesidadProductoType(), $entity, array(
            'action' => $this->generateUrl('ordennecesidadproducto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing OrdenNecesidadProducto entity.
     *
     * @Route("/{id}", name="ordennecesidadproducto_update")
     *
     * @Method("PUT")
     * @Template("BusetaTallerBundle:OrdenNecesidadProducto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:OrdenNecesidadProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrdenNecesidadProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ordennecesidadproducto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @param OrdenNecesidadProducto $ordennecesidadproducto
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/delete", name="ordentrabajo_ordennecesidadproducto_delete", methods={"GET", "POST", "DELETE"}, options={"expose":true})
     */
    public function deleteAction(OrdenNecesidadProducto $ordennecesidadproducto, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($ordennecesidadproducto->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($ordennecesidadproducto);
                $em->flush();

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle'),
                    ), 202);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'OrdenNecesidadProducto'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaTaller/OrdenNecesidadProducto/delete_modal.html.twig', array(
            'entity' => $ordennecesidadproducto,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return new Response($renderView);
    }

    /**
     * Creates a form to delete a OrdenNecesidadProducto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ordentrabajo_ordennecesidadproducto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
