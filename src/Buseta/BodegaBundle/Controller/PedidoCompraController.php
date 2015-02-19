<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Entity\InformeProductosBodega;
use Buseta\BodegaBundle\Entity\InformeStock;
use Buseta\BodegaBundle\Entity\PedidoCompraLinea;
use Buseta\BodegaBundle\Form\Type\PedidoCompraLineaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\BodegaBundle\Entity\PedidoCompra;
use Buseta\BodegaBundle\Form\Type\PedidoCompraType;
use Buseta\BodegaBundle\Form\Filtro\BusquedaPedidoCompraType;

/**
 * PedidoCompra controller.
 *
 */
class PedidoCompraController extends Controller
{
    public function busquedaAvanzadaAction($page,$cantResult){
        $em = $this->get('doctrine.orm.entity_manager');
        $request = $this->getRequest();

        $orderBy = $request->query->get('orderBy');
        $filter  = $request->query->get('filter');

        $filter = $filter;

        $busqueda = $em->getRepository('BusetaBodegaBundle:PedidoCompra')
            ->busquedaAvanzada($page,$cantResult,$filter,$orderBy);
        $paginacion = $busqueda['paginacion'];
        $results    = $busqueda['results'];

        return $this->render('BusetaBodegaBundle:Extras/table:busqueda-avanzada-pedidos-compras.html.twig',array(
            'pedidosCompras'   => $results,
            'page'       => $page,
            'cantResult' => $cantResult,
            'orderBy'    => $orderBy,
            'paginacion' => $paginacion,
        ));
    }

    public function comprobarPedidoAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest())
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);

        $em = $this->getDoctrine()->getManager();

        $error = "Sin errores";

        $consecutivo_compra = $request->query->get('consecutivo_compra');
        $importe_total_lineas = $request->query->get('importe_total_lineas');
        $importe_total = $request->query->get('importe_total');

        if($request->query->get('numero_documento'))
        {
            $numero_documento = $request->query->get('numero_documento');
        }
        else { $error = "error"; }

        if($request->query->get('fecha_pedido'))
        {
            $fecha_pedido = $request->query->get('fecha_pedido');

            //$fecha = new \DateTime('now');
            $date='%s-%s-%s GMT-0';
            $fecha = explode("/", $fecha_pedido);
            $d = $fecha[0]; $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fecha_pedido =  new \DateTime(sprintf($date,$y,$m,$d));
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

        if($request->query->get('forma_pago'))
        {
            $forma_pago = $request->query->get('forma_pago');
        }
        else { $error = "error"; }

        if($request->query->get('condiciones_pago'))
        {
            $condiciones_pago = $request->query->get('condiciones_pago');
        }
        else { $error = "error"; }

        if($request->query->get('moneda'))
        {
            $moneda = $request->query->get('moneda');
        }
        else { $error = "error"; }

        /*if($error != 'error')
        {
            $tercero = $em->getRepository('BusetaBodegaBundle:Tercero')->find($tercero);
            $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($almacen);
            $forma_pago = $em->getRepository('BusetaNomencladorBundle:FormaPago')->find($forma_pago);
            $condiciones_pago = $em->getRepository('BusetaTallerBundle:CondicionesPago')->find($condiciones_pago);
            $moneda = $em->getRepository('BusetaNomencladorBundle:Moneda')->find($moneda);

            $pedidoCompra = new PedidoCompra();
            $pedidoCompra->setNumeroDocumento($numero_documento);
            $pedidoCompra->setConsecutivoCompra($consecutivo_compra);
            $pedidoCompra->setTercero($tercero);
            $pedidoCompra->setAlmacen($almacen);
            $pedidoCompra->setFechaPedido($fecha_pedido);
            $pedidoCompra->setFormaPago($forma_pago);
            $pedidoCompra->setCondicionesPago($condiciones_pago);
            $pedidoCompra->setMoneda($moneda);
            $pedidoCompra->setImporteTotalLineas($importe_total_lineas);
            $pedidoCompra->setImporteTotal($importe_total);

            $em->persist($pedidoCompra);
            $em->flush();
        }*/

        $json = array(
            //'id' => $numero_documento,
            'error' => $error,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Lists all PedidoCompra entities.
     *
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $pedidoCompra = $this->createForm(new BusquedaPedidoCompraType());

        return $this->render('BusetaBodegaBundle:PedidoCompra:index.html.twig', array(
            'pedidoCompra' => $pedidoCompra->createView(),
        ));
    }

    public function procesarPedidoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $pedidoCompra = $em->getRepository('BusetaBodegaBundle:PedidoCompra')->find($id);

        if (!$pedidoCompra) {
            throw $this->createNotFoundException('Unable to find PedidoCompra entity.');
        }

        $fecha =  new \DateTime();

        $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($pedidoCompra->getAlmacen());
        $tercero = $em->getRepository('BusetaBodegaBundle:Tercero')->find($pedidoCompra->getTercero());

        //registro los datos del nuevo albarán que se crear al procesar el pedido
        $albaran = new Albaran();
        $albaran->setEstadoDocumento($pedidoCompra->getEstadoDocumento());
        $albaran->setAlmacen($almacen);
        $albaran->setConsecutivoCompra($pedidoCompra->getConsecutivoCompra());
        $albaran->setTercero($tercero);
        $albaran->setCreated(new \DateTime());

        $em->persist($albaran);
        $em->flush();

        //registro los datos de las líneas del albarán
        foreach($pedidoCompra->getPedidoCompraLineas() as $linea){

            $albaranLinea = new AlbaranLinea();
            $albaranLinea->setAlbaran($albaran);
            $albaranLinea->setLinea($linea->getLinea());
            $albaranLinea->setCantidadMovida($linea->getCantidadPedido());

            $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($linea->getProducto());
            $albaranLinea->setProducto($producto);

            $albaranLinea->setAlmacen($almacen);

            $uom = $em->getRepository('BusetaNomencladorBundle:UOM')->find($linea->getUOM());
            $albaranLinea->setUom($uom);

            $em->persist($albaranLinea);
            $em->flush();
        }

        $pedidoCompra->setDeleted(true);
        $em->persist($pedidoCompra);
        $em->flush();

        return $this->redirect($this->generateUrl('pedidocompra'));
    }

    public function createAction(Request $request)
    {
        $entity = new PedidoCompra();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setCreated(new \DateTime());

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pedidocompra_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:PedidoCompra:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a PedidoCompra entity.
    *
    * @param PedidoCompra $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PedidoCompra $entity)
    {
        $form = $this->createForm('bodega_pedido_compra', $entity, array(
            'action' => $this->generateUrl('pedidocompra_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PedidoCompra entity.
     *
     */
    public function newAction()
    {
        $entity = new PedidoCompra();

        $pedido_compra_linea = new PedidoCompraLinea();

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $json = array();
        $precioSalida = 0;

        foreach($productos as $p){


            foreach($p->getPrecioProducto() as $precios)
            {
                if($precios->getActivo())
                {
                    $precioSalida = ($precios->getPrecio());
                }
            }

            $json[$p->getId()] = array(
                'nombre' => $p->getNombre(),
                //'precio_salida' => $p->getPrecioSalida(),
                'precio_salida' => $precioSalida,
            );
        }

        $pedido_compra_linea = $this->createForm(new PedidoCompraLineaType());
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:PedidoCompra:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'pedido_compra_linea'  => $pedido_compra_linea->createView(),
            'json'   => json_encode($json),
        ));
    }

    /**
     * Finds and displays a PedidoCompra entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PedidoCompra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoCompra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:PedidoCompra:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing PedidoCompra entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PedidoCompra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoCompra entity.');
        }

        $linea = $this->createForm(new PedidoCompraLineaType());

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $json = array();

        foreach($productos as $p){

            foreach($p->getPrecioProducto() as $precios)
            {
                if($precios->getActivo())
                {
                    $precioSalida = ($precios->getPrecio());
                }
            }

            $json[$p->getId()] = array(
                'nombre' => $p->getNombre(),
                'precio_salida' => $precioSalida,
            );
        }

        return $this->render('BusetaBodegaBundle:PedidoCompra:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'pedido_compra_linea'       => $linea->createView(),
            'delete_form' => $deleteForm->createView(),
            'json'   => json_encode($json),
        ));
    }

    /**
    * Creates a form to edit a PedidoCompra entity.
    *
    * @param PedidoCompra $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PedidoCompra $entity)
    {
        $form = $this->createForm('bodega_pedido_compra',$entity, array(
            'action' => $this->generateUrl('pedidocompra_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing PedidoCompra entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:PedidoCompra')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoCompra entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setCreated($entity->getCreated());
            $entity->setUpdated(new \DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('pedidocompra_show', array('id' => $id)));
        }

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $json = array();

        foreach($productos as $p){

            $json[$p->getId()] = array(
                'nombre' => $p->getNombre(),
                'precio_salida' => $p->getPrecioSalida(),
            );
        }

        return $this->render('BusetaBodegaBundle:PedidoCompra:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'json'   => json_encode($json),
        ));
    }

    /**
     * Deletes a PedidoCompra entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:PedidoCompra')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PedidoCompra entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pedidocompra'));
    }

    /**
     * Creates a form to delete a PedidoCompra entity by id.
     *
     * @param mixed $id The entity id
     *º
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedidocompra_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
