<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\NecesidadMaterial;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\NecesidadMaterialLinea;
use Buseta\BodegaBundle\Form\Type\NecesidadMaterialLineaType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class NecesidadMaterialLineaController
 * @package Buseta\BodegaBundle\Controller
 *
 * @Route("/necesidadmaterial_linea")
 */
class NecesidadMaterialLineaController extends Controller
{
    /**
     * @param NecesidadMaterial $necesidadmaterial
     * @return Response
     *
     * @Route("/list/{necesidadmaterial}", name="necesidadmaterial_lineas_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("necesidadmaterial", options={"mapping":{"necesidadmaterial":"id"}})
     */
    public function listAction(NecesidadMaterial $necesidadmaterial, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:NecesidadMaterialLinea')
            ->findAllByNecesidadMaterialId($necesidadmaterial->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaBodega/NecesidadMaterial/Linea/list_template.html.twig', array(
            'entities' => $entities,
            'necesidadmaterial' => $necesidadmaterial,
        ));
    }

    /**
     * @param NecesidadMaterial $necesidadmaterial
     * @param Request $request
     *
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new/{necesidadmaterial}", name="necesidadmaterial_lineas_new_modal", options={"expose":true})
     * @Method({"GET","POST"})
     * @ParamConverter("necesidadmaterial", options={"mapping":{"necesidadmaterial":"id"}})
     */
    public function newModalAction(NecesidadMaterial $necesidadmaterial, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('buseta_necesidadmaterial.linea.handler');
        $handler->bindData($necesidadmaterial);

        $handler->setRequest($request);

        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Línea'), 'BusetaBodegaBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/Linea/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * @param NecesidadMaterial $necesidadmaterial
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     *
     * @Route("/{id}/edit/{necesidadmaterial}", name="necesidadmaterial_lineas_edit_modal", options={"expose":true})
     * @Method({"GET","PUT"})
     * @ParamConverter("necesidadmaterial", options={"mapping":{"necesidadmaterial":"id"}})
     */
    public function editModalAction(NecesidadMaterialLinea $necesidadMaterialLinea, NecesidadMaterial $necesidadmaterial, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('buseta_necesidadmaterial.linea.handler');
        $handler->bindData($necesidadmaterial, $necesidadMaterialLinea);

        $handler->setRequest($request);

        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Línea'), 'BusetaBodegaBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/Linea/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Lists all NecesidadMaterialLinea entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:NecesidadMaterialLinea')->findAll();

        return $this->render('BusetaBodegaBundle:NecesidadMaterialLinea:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new NecesidadMaterialLinea entity.
     */
    public function createAction(Request $request)
    {
        $entity = new NecesidadMaterialLinea();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linea_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:NecesidadMaterialLinea:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function create_compraAction(Request $request)
    {
        $entity = new NecesidadMaterialLinea();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Creates a form to create a NecesidadMaterialLinea entity.
     *
     * @param NecesidadMaterialLinea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NecesidadMaterialLinea $entity)
    {
        $form = $this->createForm(new NecesidadMaterialLineaType(), $entity, array(
            'action' => $this->generateUrl('linea_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a NecesidadMaterialLinea entity.
     *
     * @param NecesidadMaterialLinea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateCompraForm(NecesidadMaterialLinea $entity)
    {
        $form = $this->createForm(new NecesidadMaterialLineaType(), $entity, array(
            'action' => $this->generateUrl('linea_compra_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new NecesidadMaterialLinea entity.
     */
    public function newAction()
    {
        $entity = new NecesidadMaterialLinea();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:NecesidadMaterialLinea:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a NecesidadMaterialLinea entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:NecesidadMaterialLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NecesidadMaterialLinea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:NecesidadMaterialLinea:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing NecesidadMaterialLinea entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:NecesidadMaterialLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NecesidadMaterialLinea entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:NecesidadMaterialLinea:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a NecesidadMaterialLinea entity.
     *
     * @param NecesidadMaterialLinea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(NecesidadMaterialLinea $entity)
    {
        $form = $this->createForm(new NecesidadMaterialLineaType(), $entity, array(
            'action' => $this->generateUrl('linea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing NecesidadMaterialLinea entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:NecesidadMaterialLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NecesidadMaterialLinea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('linea_edit', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:NecesidadMaterialLinea:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a NecesidadMaterialLinea entity.
     * @Route("/{id}/delete", name="necesidadmaterial_lineas_delete", options={"expose": true})
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(Request $request, NecesidadMaterialLinea $necesidadMaterialLinea)
    {
        $form = $this->createDeleteForm($necesidadMaterialLinea->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            try {
                $em->remove($necesidadMaterialLinea);
                $em->flush();

                $message = $this->get('translator')->trans('messages.delete.success', array(), 'BusetaBodegaBundle');
                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array('message' => $message), 202);
                }
            } catch (\Exception $e) {
                $message = $this->get('translator')->trans('messages.delete.error.%key%', array('key' => 'Linea Registro de Compra'), 'BusetaBodegaBundle');
                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array('message' => $message), 500);
                }
            }
        }

        if ($request->isXmlHttpRequest()) {
            $view = $this->renderView('@BusetaBodega/NecesidadMaterial/Linea/delete_modal.html.twig', array(
                'entity'    => $necesidadMaterialLinea,
                'form'      => $form->createView(),
            ));

            return new JsonResponse(array(
                'view' => $view
            ), 200);
        }

        return $this->redirect($this->generateUrl('linea'));
    }

    /**
     * Creates a form to delete a NecesidadMaterialLinea entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('necesidadmaterial_lineas_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
