<?php

namespace Buseta\BodegaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\CostoProducto;
use Buseta\BodegaBundle\Form\Type\CostoProductoType;
use Buseta\BodegaBundle\Entity\Producto;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * CostoProducto controller.
 *
 * @Route("/costoproducto")
 */
class CostoProductoController extends Controller
{
    /**
     * @param Producto $producto
     * @return Response
     *
     * @Route("/list/{producto}", name="producto_costos_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("producto", options={"mapping":{"producto":"id"}})
     */
    public function listAction(Producto $producto, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:CostoProducto')
            ->findAllByProductoId($producto->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                5
            );

        return $this->render('@BusetaBodega/Producto/Costo/list_template.html.twig', array(
            'entities' => $entities,
            'producto' => $producto,
        ));
    }

    /**
     * @param Producto $producto
     * @param Request $request
     *
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/{producto}", name="producto_costos_new_modal", methods={"GET","POST"}, options={"expose":true})
     */
    public function newModalAction(Producto $producto, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('buseta_producto.costo.handler');
        $handler->bindData($producto);

        $handler->setRequest($request);

        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaBodega/Producto/Costo/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaBodega/Producto/Costo/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Costo'), 'BusetaBodegaBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaBodega/Producto/Costo/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    public function select_costo_productos_allAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $json = array(
            'ok' => 'ok',
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    public function comprobarCostoAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();

        $error = "Sin errores";

        if ($request->query->get('nombre')) {
            $nombre = $request->query->get('nombre');
        } else {
            $error = "error";
        }

        if ($request->query->get('codigo')) {
            $codigo = $request->query->get('codigo');
        } else {
            $error = "error";
        }

        if ($request->query->get('uom')) {
            $uom = $request->query->get('uom');
        } else {
            $error = "error";
        }

        if ($request->query->get('bodega')) {
            $bodega = $request->query->get('bodega');
        } else {
            $error = "error";
        }

        if ($request->query->get('minimo_bodega') != null) {
            $minimo_bodega = $request->query->get('minimo_bodega');
        } else {
            $error = "error";
        }

        if ($request->query->get('maximo_bodega') != null) {
            $maximo_bodega = $request->query->get('maximo_bodega');
        } else {
            $error = "error";
        }

        if ($request->query->get('grupos')) {
            $grupos = $request->query->get('grupos');
        } else {
            $error = "error";
        }

        if ($request->query->get('subgrupos')) {
            $subgrupos = $request->query->get('subgrupos');
        } else {
            $error = "error";
        }

        if ($request->query->get('condicion')) {
            $condicion = $request->query->get('condicion');
        } else {
            $error = "error";
        }

        if ($request->query->get('activo')) {
            $activo = $request->query->get('activo');
        } else {
            $error = "error";
        }

        $json = array(
            'error' => $error,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Lists all CostoProducto entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:CostoProducto')->findAll();

        return $this->render('BusetaBodegaBundle:CostoProducto:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new CostoProducto entity.
     */
    public function createAction(Request $request)
    {
        $entity = new CostoProducto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linea_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:CostoProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function create_compraAction(Request $request)
    {
        die;
        $entity = new CostoProducto();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Creates a form to create a CostoProducto entity.
     *
     * @param CostoProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CostoProducto $entity)
    {
        $form = $this->createForm(new CostoProductoType(), $entity, array(
            'action' => $this->generateUrl('linea_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a CostoProducto entity.
     *
     * @param CostoProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateCompraForm(CostoProducto $entity)
    {
        $form = $this->createForm(new CostoProductoType(), $entity, array(
                'action' => $this->generateUrl('linea_compra_create'),
                'method' => 'POST',
            ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CostoProducto entity.
     */
    public function newAction()
    {
        $entity = new CostoProducto();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:CostoProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CostoProducto entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CostoProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CostoProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:CostoProducto:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing CostoProducto entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CostoProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CostoProducto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:CostoProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a CostoProducto entity.
     *
     * @param CostoProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(CostoProducto $entity)
    {
        $form = $this->createForm(new CostoProductoType(), $entity, array(
            'action' => $this->generateUrl('linea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing CostoProducto entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:CostoProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CostoProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('linea_edit', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:CostoProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a CostoProducto entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:CostoProducto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CostoProducto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('linea'));
    }

    /**
     * Creates a form to delete a CostoProducto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('linea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
