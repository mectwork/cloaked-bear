<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\InformeProductosBodega;
use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BodegaBundle\Form\Type\ProductoType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Form\Filtro\BusquedaProductoType;

/**
 * Producto controller.
 *
 */
class ProductoController extends Controller
{
    public function productoBitacoraAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($id);

        $bitacora = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->findBy(
            array(
                'producto' => $producto
            )
        );

        $paginator = $this->get('knp_paginator');
        $bitacora = $paginator->paginate(
            $bitacora,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaBodegaBundle:Producto:bitacora.html.twig', array(
            'bitacora' => $bitacora,
            'producto' => $producto,
        ));


    }

    public function busquedaAvanzadaAction($page,$cantResult){
        $em = $this->get('doctrine.orm.entity_manager');
        $request = $this->getRequest();

        $orderBy = $request->query->get('orderBy');
        $filter  = $request->query->get('filter');

        $filter = $filter;

        $busqueda = $em->getRepository('BusetaBodegaBundle:Producto')
            ->busquedaAvanzada($page,$cantResult,$filter,$orderBy);
        $paginacion = $busqueda['paginacion'];
        $results    = $busqueda['results'];

        return $this->render('BusetaBodegaBundle:Extras/table:busqueda-avanzada-productos.html.twig',array(
            'productos'   => $results,
            'page'       => $page,
            'cantResult' => $cantResult,
            'orderBy'    => $orderBy,
            'paginacion' => $paginacion,
        ));
    }

    /**
     * Updated automatically select All when change select Producto
     *
     */
    public function select_productos_allAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest())
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);

        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->findOneBy(array(
            'id' => $request->query->get('producto_id')
        ));

        $impuesto = $em->getRepository('BusetaTallerBundle:Impuesto')->findOneBy(array(
            'id' => $request->query->get('impuesto_id')
        ));

        $cantidad_pedido     = $request->query->get('cantidad_pedido');
        $precio_unitario     = $producto->getPrecioCosto();
        $porciento_descuento = $request->query->get('porciento_descuento');

        $funcionesExtras = new FuncionesExtras();
        $importeLinea = $funcionesExtras->ImporteLinea($impuesto, $cantidad_pedido, $precio_unitario, $porciento_descuento);

        $json = array(
            'id' => $producto->getId(),
            'precio' => $producto->getPrecioCosto(),
            'importeLinea' => $importeLinea,
            'porciento_descuento' => $porciento_descuento,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Updated automatically select Subgrupos when change select Grupos
     *
     */
    public function select_grupo_subgrupoAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest())
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);

        $em = $this->getDoctrine()->getManager();
        $subgrupos = $em->getRepository('BusetaNomencladorBundle:Subgrupo')->findBy(array(
            'grupo' => $request->query->get('grupo_id')
        ));

        $json = array();
        foreach ($subgrupos as $subgrupo) {
            $json[] = array(
                'id' => $subgrupo->getId(),
                'valor' => $subgrupo->getValor(),
            );
        }

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Lists all Producto entities.
     *
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $producto = $this->createForm(new BusquedaProductoType());

        return $this->render('BusetaBodegaBundle:Producto:index.html.twig', array(
            'producto' => $producto->createView(),
        ));
    }

    /**
     * Creates a new Producto entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Producto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('producto_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Producto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Producto entity.
    *
    * @param Producto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Producto entity.
     *
     */
    public function newAction()
    {
        $entity = new Producto();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:Producto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Producto entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Producto:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Producto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Producto entity.
    *
    * @param Producto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Producto entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('producto_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Producto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Producto entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:Producto')->find($id);

           if (!$entity) {
                throw $this->createNotFoundException('Unable to find Producto entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Ha sido eliminado satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('logger')->addCritical(
                    sprintf('Ha ocurrido un error eliminando un Producto. Detalles: %s',
                        $e->getMessage()
                    ));
            }
        }

        return $this->redirect($this->generateUrl('producto'));
    }

    /**
     * Creates a form to delete a Producto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
