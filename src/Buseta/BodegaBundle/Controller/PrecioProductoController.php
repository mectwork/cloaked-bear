<?php

namespace Buseta\BodegaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\PrecioProducto;
use Buseta\BodegaBundle\Form\Type\PrecioProductoType;
use Buseta\BodegaBundle\Entity\Producto;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * PrecioProducto controller.
 *
 * @Route("/precioproducto")
 */
class PrecioProductoController extends Controller
{
    /**
     * @param Producto $producto
     * @return Response
     *
     * @Route("/list/{producto}", name="producto_precios_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("producto", options={"mapping":{"producto":"id"}})
     */
    public function listAction(Producto $producto, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:PrecioProducto')
            ->findAllByProductoId($producto->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaBodega/Producto/Precio/list_template.html.twig', array(
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
     * @Route("/new/modal/{producto}", name="producto_precios_new_modal", methods={"GET","POST"}, options={"expose":true})
     */
    public function newModalAction(Producto $producto, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('buseta_producto.precio.handler');
        $handler->bindData($producto);

        $handler->setRequest($request);

        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaBodega/Producto/Precio/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaBodega/Producto/Precio/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Precio'), 'BusetaBodegaBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaBodega/Producto/Precio/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    public function select_precio_productos_allAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
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

    public function comprobarPrecioAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
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
     * Lists all PrecioProducto entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:PrecioProducto')->findAll();

        return $this->render('BusetaBodegaBundle:PrecioProducto:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new PrecioProducto entity.
     */
    public function createAction(Request $request)
    {
        $entity = new PrecioProducto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linea_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:PrecioProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function create_compraAction(Request $request)
    {
        die;
        $entity = new PrecioProducto();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Creates a form to create a PrecioProducto entity.
     *
     * @param PrecioProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PrecioProducto $entity)
    {
        $form = $this->createForm(new PrecioProductoType(), $entity, array(
            'action' => $this->generateUrl('linea_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a PrecioProducto entity.
     *
     * @param PrecioProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateCompraForm(PrecioProducto $entity)
    {
        $form = $this->createForm(new PrecioProductoType(), $entity, array(
                'action' => $this->generateUrl('linea_compra_create'),
                'method' => 'POST',
            ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PrecioProducto entity.
     */
    public function newAction()
    {
        $entity = new PrecioProducto();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:PrecioProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PrecioProducto entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PrecioProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrecioProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:PrecioProducto:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing PrecioProducto entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PrecioProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrecioProducto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:PrecioProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a PrecioProducto entity.
     *
     * @param PrecioProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(PrecioProducto $entity)
    {
        $form = $this->createForm(new PrecioProductoType(), $entity, array(
            'action' => $this->generateUrl('linea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing PrecioProducto entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PrecioProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PrecioProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('linea_edit', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:PrecioProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PrecioProducto entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:PrecioProducto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PrecioProducto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('linea'));
    }

    /**
     * Creates a form to delete a PrecioProducto entity by id.
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
