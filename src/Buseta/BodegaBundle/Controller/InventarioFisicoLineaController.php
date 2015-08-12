<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\InventarioFisico;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Form\Type\InventarioFisicoLineaType;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class InventarioFisicoLineaController
 * @package Buseta\BodegaBundle\Controller
 *
 * @Route("/inventariofisico_linea")
 */
class InventarioFisicoLineaController extends Controller
{
    /**
     * @param InventarioFisico $inventariofisico
     * @return Response
     *
     * @Route("/list/{inventariofisico}", name="inventariofisico_lineas_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("inventariofisico", options={"mapping":{"inventariofisico":"id"}})
     */
    public function listAction(InventarioFisico $inventariofisico, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:InventarioFisicoLinea')
            ->findAllByInventarioFisicoId($inventariofisico->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );


        return $this->render('@BusetaBodega/InventarioFisico/Linea/list_template.html.twig', array(
            'entities' => $entities,
            'inventariofisico' => $inventariofisico,
            'id' => $inventariofisico->getId(),
        ));
    }

    /**
     * @param InventarioFisico $inventariofisico
     * @param Request $request
     *
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/{inventariofisico}", name="inventariofisico_lineas_new_modal", methods={"GET","POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newModalAction(InventarioFisico $inventariofisico, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('buseta_inventariofisico.linea.handler');
        $handler->bindData($inventariofisico);

        $handler->setRequest($request);

        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaBodega/InventarioFisico/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaBodega/InventarioFisico/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Línea'), 'BusetaBodegaBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaBodega/InventarioFisico/Linea/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Lists all InventarioFisicoLinea entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:InventarioFisicoLinea')->findAll();

        return $this->render('BusetaBodegaBundle:InventarioFisicoLinea:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new InventarioFisicoLinea entity.
     */
    public function createAction(Request $request)
    {
        $entity = new InventarioFisicoLinea();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linea_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:InventarioFisicoLinea:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function create_compraAction(Request $request)
    {
        $entity = new InventarioFisicoLinea();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Creates a form to create a InventarioFisicoLinea entity.
     *
     * @param InventarioFisicoLinea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InventarioFisicoLinea $entity)
    {
        $form = $this->createForm(new InventarioFisicoLineaType(), $entity, array(
            'action' => $this->generateUrl('linea_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a InventarioFisicoLinea entity.
     *
     * @param InventarioFisicoLinea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateCompraForm(InventarioFisicoLinea $entity)
    {
        $form = $this->createForm(new InventarioFisicoLineaType(), $entity, array(
                'action' => $this->generateUrl('linea_compra_create'),
                'method' => 'POST',
            ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new InventarioFisicoLinea entity.
     */
    public function newAction()
    {
        $entity = new InventarioFisicoLinea();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:InventarioFisicoLinea:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InventarioFisicoLinea entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:InventarioFisicoLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventarioFisicoLinea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:InventarioFisicoLinea:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing InventarioFisicoLinea entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:InventarioFisicoLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventarioFisicoLinea entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:InventarioFisicoLinea:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a InventarioFisicoLinea entity.
     *
     * @param InventarioFisicoLinea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(InventarioFisicoLinea $entity)
    {
        $form = $this->createForm(new InventarioFisicoLineaType(), $entity, array(
            'action' => $this->generateUrl('linea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing InventarioFisicoLinea entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:InventarioFisicoLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InventarioFisicoLinea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('linea_edit', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:InventarioFisicoLinea:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a InventarioFisicoLinea entity.
     *
     * @Route("/{id}/delete", name="inventario_fisico_linea_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(InventarioFisicoLinea $inventariofisicoLinea, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($inventariofisicoLinea->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($inventariofisicoLinea);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Línea'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/InventarioFisico/Linea/delete_modal.html.twig', array(
            'entity' => $inventariofisicoLinea,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('inventariofisico_lineas_list'));
    }

    /**
     * Creates a form to delete a InventarioFisicoLinea entity by id.
     *
     * @param mixed $id The entity id
     *º
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('inventario_fisico_linea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
