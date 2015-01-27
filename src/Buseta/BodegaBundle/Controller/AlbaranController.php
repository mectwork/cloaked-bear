<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\InformeProductosBodega;
use Buseta\BodegaBundle\Entity\InformeStock;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Form\Type\AlbaranLineaType;
use Buseta\BodegaBundle\Form\Type\PedidoCompraLineaType;
use Buseta\BodegaBundle\Form\Type\PedidoCompraType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Form\Type\AlbaranType;

/**
 * Albaran controller.
 *
 */
class AlbaranController extends Controller
{
    public function guardarAlbaranAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest())
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);

        $em = $this->getDoctrine()->getManager();

        $error = "Sin errores";

        if($request->query->get('estadoDocumento'))
        {
            $estadoDocumento = $request->query->get('estadoDocumento');
        }
        else { $error = "error"; }

        if($request->query->get('fechaMovimiento'))
        {
            $fechaMovimiento = $request->query->get('fechaMovimiento');

            //$fecha = new \DateTime('now');
            $date='%s-%s-%s GMT-0';
            $fecha = explode("/", $fechaMovimiento);
            $d = $fecha[0]; $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fechaMovimiento =  new \DateTime(sprintf($date,$y,$m,$d));
        }
        else { $error = "error"; }

        if($request->query->get('fechaContable'))
        {
            $fechaContable = $request->query->get('fechaContable');

            //$fecha = new \DateTime('now');
            $date='%s-%s-%s GMT-0';
            $fecha = explode("/", $fechaContable);
            $d = $fecha[0]; $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fechaContable =  new \DateTime(sprintf($date,$y,$m,$d));
        }
        else { $error = "error"; }

        if($request->query->get('tercero'))
        {
            $tercero = $request->query->get('tercero');
        }
        else { $error = "error"; }

        if($request->query->get('almacen'))
        {
            $almacen = $request->query->get('almacen');
        }
        else { $error = "error"; }

        if($request->query->get('numeroReferencia'))
        {
            $numeroReferencia = $request->query->get('numeroReferencia');
        }
        else { $error = "error"; }

        if($request->query->get('consecutivoCompra'))
        {
            $consecutivoCompra = $request->query->get('consecutivoCompra');
        }
        else { $error = "error"; }

        $json = array(
            'error' => $error,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    public function select_albaran_ajaxAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest())
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);

        $em = $this->getDoctrine()->getManager();

        $linea = $request->query->get('linea');

        $json = array(
            'linea' => $linea,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Finds and displays a Albaran entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Albaran entity.');
        }

        return $this->render('BusetaBodegaBundle:Albaran:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Lists all Albaran entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:Albaran')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            5,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaBodegaBundle:Albaran:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to edit an existing Albaran entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Albaran entity.');
        }

        $albaranLinea = $this->createForm(new AlbaranLineaType());

        $editForm = $this->createEditForm($entity);

        $em = $this->getDoctrine()->getManager();

        return $this->render('BusetaBodegaBundle:Albaran:edit.html.twig', array(
            'entity'        => $entity,
            'edit_form'     => $editForm->createView(),
            'albaranLinea'  => $albaranLinea->createView(),
        ));
    }

    /**
     * Creates a form to edit a PedidoCompra entity.
     *
     * @param PedidoCompra $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Albaran $entity)
    {
        $form = $this->createForm('bodega_albaran_type',$entity, array(
            'action' => $this->generateUrl('albaran_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Albaran entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $albaran = $em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

        $request = $this->get('request');
        $datos = $request->request->get('bodega_albaran_type');

        //Actualizar Albaran
        $albaran->setNumeroReferencia($datos['numeroReferencia']);

        $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($datos['almacen']);
        $albaran->setAlmacen($almacen);

        $albaran->setConsecutivoCompra($datos['consecutivoCompra']);
        $albaran->setEstadoDocumento($datos['estadoDocumento']);

        if($datos['fechaContable']){
            $date='%s-%s-%s GMT-0';
            $fecha = explode("/", $datos['fechaContable']);
            $d = $fecha[0]; $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fechaContable =  new \DateTime(sprintf($date,$y,$m,$d));
            $albaran->setFechaContable($fechaContable);
        }

        if($datos['fechaMovimiento']){
            $date='%s-%s-%s GMT-0';
            $fecha = explode("/", $datos['fechaMovimiento']);
            $d = $fecha[0]; $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fechaMovimiento =  new \DateTime(sprintf($date,$y,$m,$d));
            $albaran->setFechaMovimiento($fechaMovimiento);
        }

        $em->flush();

        //Actualizar Lineas del Albaran
        //registro los datos de las líneas del albarán
        foreach($datos['albaranLinea'] as $linea){
            $albaranLinea = $em->getRepository('BusetaBodegaBundle:AlbaranLinea')->findOneBy(array(
                'albaran' => $albaran
            ));

            $albaranLinea->setLinea($linea['linea']);
            $albaranLinea->setCantidadMovida($linea['cantidadMovida']);

            $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($linea['producto']);
            $albaranLinea->setProducto($producto);

            $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($datos['almacen']);
            $albaranLinea->setAlmacen($almacen);

            $uom = $em->getRepository('BusetaNomencladorBundle:UOM')->find($linea['uom']);
            $albaranLinea->setUom($uom);

            $albaranLinea->setValorAtributos($linea['valorAtributos']);

            $em->persist($albaranLinea);
            $em->flush();

            //Actualizar Bitacora
            $bitacora = new BitacoraAlmacen();
            $bitacora->setProducto($producto);
            $bitacora->setFechaMovimiento($fechaMovimiento);
            $bitacora->setAlmacen($almacen);
            $bitacora->setCantMovida($linea['cantidadMovida']);
            $bitacora->setTipoMovimiento('V+');
            $em->persist($bitacora);
            $em->flush();

            //Actualizar InformeStock
            //Comprobar que no exista ya un almacén con un producto determinado
            $informeStock = $em->getRepository('BusetaBodegaBundle:InformeStock')->comprobarInformeStock($almacen,$producto);

            //Si ya existe un producto en un almacen determinado
            if($informeStock)
            {
                $informeStock->setCantidadProductos($bitacora->getCantMovida() + $informeStock->getCantidadProductos());
                $informeStock->setUom($bitacora->getProducto()->getUOM());
                $em->persist($informeStock);
                $em->flush();
            }
            else //Si no existe
            {
                $informeStock = new InformeStock();
                $informeStock->setProducto($bitacora->getProducto());
                $informeStock->setAlmacen($bitacora->getAlmacen());
                $informeStock->setCantidadProductos($bitacora->getCantMovida());
                $informeStock->setUom($bitacora->getProducto()->getUOM());
                $em->persist($informeStock);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('albaran_show', array('id' => $id)));
    }

    /**
     * Creates a new Albaran entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Albaran();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('albaran_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Albaran:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Bodega entity.
     *
     * @param Albaran $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Albaran $entity)
    {
        $form = $this->createForm(new AlbaranType(), $entity, array(
            'action' => $this->generateUrl('albaran_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Albaran entity.
     *
     */
    public function newAction()
    {
        $entity = new Albaran();

        $albaran_linea = new AlbaranLinea();
        $albaran_linea = $this->createForm(new AlbaranLineaType());


        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:Albaran:new.html.twig', array(
            'entity' => $entity,
            'albaran_linea'  => $albaran_linea->createView(),
            'form'   => $form->createView(),
        ));
    }

}
