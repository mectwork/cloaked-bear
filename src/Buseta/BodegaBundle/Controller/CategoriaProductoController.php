<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Form\Filter\CategoriaProductoFilter;
use Buseta\BodegaBundle\Form\Model\CategoriaProductoFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\CategoriaProducto;
use Buseta\BodegaBundle\Form\Type\CategoriaProductoType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
/**
 * CategoriaProducto controller.
 *
 * @Route("/categoriaproducto")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Bodegas", routeName="bodega_principal")
 */
class CategoriaProductoController extends Controller
{
    /**
     * Lists all CategoriaProducto entities.
     * @Route("/", name="categoriaproducto")
     * @Method("GET")
     * @Breadcrumb(title="Listado de Categorías de Producto", routeName="categoriaproducto")
     */
    public function indexAction(Request $request)
    {
        $filter = new CategoriaProductoFilterModel();

        $form = $this->createForm(new CategoriaProductoFilter(), $filter, array(
            'action' => $this->generateUrl('categoria_producto'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:CategoriaProducto')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:CategoriaProducto')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:CategoriaProducto:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }
    /**
     * Creates a new CategoriaProducto entity.
     * @Route("/create", name="categoria_producto_create", methods={"POST"}, options={"expose":true})
     * @Breadcrumb(title="Crear Nueva Categoría de Producto", routeName="categoria_producto_create")
     */
    public function createAction(Request $request)
    {
        $entity = new CategoriaProducto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_producto_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:CategoriaProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CategoriaProducto entity.
     *
     * @param CategoriaProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CategoriaProducto $entity)
    {
        $form = $this->createForm(new CategoriaProductoType(), $entity, array(
            'action' => $this->generateUrl('categoria_producto_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CategoriaProducto entity.
     * @Route("/new", name="categoria_producto_new", methods={"GET"}, options={"expose":true})
     * @Breadcrumb(title="Crear Nueva Categoría de Producto", routeName="categoria_producto_new")
     */
    public function newAction()
    {
        $entity = new CategoriaProducto();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:CategoriaProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoriaProducto entity.
     * @Route("/{id}/show", name="categoria_producto_show", methods={"GET"}, options={"expose":true})
     * @Breadcrumb(title="Ver Datos de Categorías de Producto", routeName="categoria_producto_show", routeParameters={"id"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:CategoriaProducto:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CategoriaProducto entity.
     * @Route("/{id}/edit", name="categoria_producto_edit", methods={"GET"}, options={"expose":true})
     * @Breadcrumb(title="Modificar Categoría de Producto", routeName="categoria_producto_edit", routeParameters={"id"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaProducto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:CategoriaProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a CategoriaProducto entity.
     *
     * @param CategoriaProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CategoriaProducto $entity)
    {
        $form = $this->createForm(new CategoriaProductoType(), $entity, array(
            'action' => $this->generateUrl('categoria_producto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CategoriaProducto entity.
     * @Route("/{id}/update", name="categoria_producto_update", options={"expose": true})
     * @Breadcrumb(title="Modificar Categoría de Producto", routeName="categoria_producto_update", routeParameters={"id"})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CategoriaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoriaProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_producto_show', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:CategoriaProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CategoriaProducto entity.
     *
     * @Route("/{id}/delete", name="categoria_producto_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(CategoriaProducto $categoriaproducto, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($categoriaproducto->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($categoriaproducto);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Categoría de Producto'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/CategoriaProducto/delete_modal.html.twig', array(
            'entity' => $categoriaproducto,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('categoria_producto'));
    }

    /**
     * Creates a form to delete a CategoriaProducto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_producto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
