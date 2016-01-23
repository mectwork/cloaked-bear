<?php

namespace Buseta\BodegaBundle\Controller;


use Buseta\BodegaBundle\Form\Filter\ProductoTopeFilter;
use Buseta\BodegaBundle\Form\Model\ProductoTopeFilterModel;
use Buseta\BodegaBundle\Entity\ProductoTope;
use Buseta\BodegaBundle\Form\Type\ProductoTopeType;
/*
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;*/


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * ProductoTope controller.
 *
 * @Route("/productotope")
 */
class ProductoTopeController extends Controller
{

    /**
     * Lists all ProductoTope entities.
     *
     * @Route("/", name="productotope")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new ProductoTopeFilterModel();

        $form = $this->createForm(new ProductoTopeFilter(), $filter, array(
            'action' => $this->generateUrl('productotope'),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:ProductoTope')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:ProductoTope')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:ProductoTope:index.html.twig', array(
            'entities' => $entities,
            'filter_form' => $form->createView(),
        ));
    }

    /**
     * Creates a new ProductoTope entity.
     *
     * @Route("/create", name="productotope_create", options={"expose":true})
     * @Method("POST")
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ProductoTope();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('productotope_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:ProductoTope:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ProductoTope entity.
     *
     * @param ProductoTope $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProductoTope $entity)
    {
        $form = $this->createForm(new ProductoTopeType(), $entity, array(
            'action' => $this->generateUrl('productotope_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductoTope entity.
     *
     * @Route("/new", name="productotope_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $entity = new ProductoTope();
        $form = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:ProductoTope:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProductoTope entity.
     *
     * @Route("/{id}/show", name="productotope_show", methods={"GET"}, options={"expose":true})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:ProductoTope')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductoTope entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:ProductoTope:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ProductoTope entity.
     *
     * @Route("/{id}/edit", name="productotope_edit", methods={"GET"}, options={"expose":true})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:ProductoTope')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductoTope entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        //var_dump('dsdd');die;

        return $this->render('BusetaBodegaBundle:ProductoTope:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a ProductoTope entity.
     *
     * @param ProductoTope $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ProductoTope $entity)
    {
        $form = $this->createForm(new ProductoTopeType(), $entity, array(
            'action' => $this->generateUrl('productotope', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }

    /**
     * Edits an existing ProductoTope entity.
     *
     * @Route("/{id}/update", name="productotope_update", options={"expose":true})
     * @Method({"PUT", "POST"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:ProductoTope')->find($id);

        //var_dump('dddd-'.$entity->getMax());die;

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto Tope entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('productotope_show', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:ProductoTope:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ProductoTope entity.
     *
     * @Route("/{id}/delete", name="productotope_delete")
     * @Method({"DELETE", "GET", "POST"})
     */
    public function deleteAction(ProductoTope $productoTope, Request $request)
    {

        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($productoTope->getId());

        $deleteForm->handleRequest($request);
        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($productoTope);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle');

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                } else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'ProductoTope'),
                    'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message . ' Detalles: %s', $e->getMessage()));

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView = $this->renderView('BusetaBodegaBundle:ProductoTope:delete_modal.html.twig', array(
            'entity' => $productoTope,
            'form' => $deleteForm->createView(),
        ));

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('productotope'));
    }

    /**
     * Creates a form to delete a ProductoTope entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('productotope_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm();
    }


}
