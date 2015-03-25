<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Entity\NecesidadMaterialLinea;
use Buseta\BodegaBundle\Entity\PedidoCompra;
use Buseta\BodegaBundle\Entity\PedidoCompraLinea;
use Buseta\BodegaBundle\Form\Filter\NecesidadMaterialFilter;
use Buseta\BodegaBundle\Form\Model\NecesidadMaterialFilterModel;
use Buseta\BodegaBundle\Form\Model\NecesidadMaterialModel;
use Buseta\BodegaBundle\Form\Type\NecesidadMaterialLineaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\NecesidadMaterial;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * NecesidadMaterial controller.
 *
 * @Route("/necesidadmaterial")
 */
class NecesidadMaterialController extends Controller
{
    public function busquedaAvanzadaAction($page, $cantResult)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $request = $this->getRequest();

        $orderBy = $request->query->get('orderBy');
        $filter  = $request->query->get('filter');

        $filter = $filter;

        $busqueda = $em->getRepository('BusetaBodegaBundle:NecesidadMaterial')
            ->busquedaAvanzada($page, $cantResult, $filter, $orderBy);
        $paginacion = $busqueda['paginacion'];
        $results    = $busqueda['results'];

        return $this->render('BusetaBodegaBundle:Extras/table:busqueda-avanzada-necesidad-materiales.html.twig', array(
            'necesidadMateriales'   => $results,
            'page'       => $page,
            'cantResult' => $cantResult,
            'orderBy'    => $orderBy,
            'paginacion' => $paginacion,
        ));
    }

    public function comprobarPedidoAction(Request $request)
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

        $consecutivo_compra = $request->query->get('consecutivo_compra');
        $importe_total_lineas = $request->query->get('importe_total_lineas');
        $importe_total = $request->query->get('importe_total');

        if ($request->query->get('numero_documento')) {
            $numero_documento = $request->query->get('numero_documento');
        } else {
            $error = "error";
        }

        if ($request->query->get('fecha_pedido')) {
            $fecha_pedido = $request->query->get('fecha_pedido');

            //$fecha = new \DateTime('now');
            $date = '%s-%s-%s GMT-0';
            $fecha = explode("/", $fecha_pedido);
            $d = $fecha[0];
            $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fecha_pedido =  new \DateTime(sprintf($date, $y, $m, $d));
        } else {
            $error = "error";
        }

        if ($request->query->get('tercero')) {
            $tercero = $request->query->get('tercero');
        } else {
            $error = "error";
        }

        if ($request->query->get('almacen')) {
            $almacen = $request->query->get('almacen');
        } else {
            $error = "error";
        }

        if ($request->query->get('forma_pago')) {
            $forma_pago = $request->query->get('forma_pago');
        } else {
            $error = "error";
        }

        if ($request->query->get('condiciones_pago')) {
            $condiciones_pago = $request->query->get('condiciones_pago');
        } else {
            $error = "error";
        }

        if ($request->query->get('moneda')) {
            $moneda = $request->query->get('moneda');
        } else {
            $error = "error";
        }
        
        $json = array(
            //'id' => $numero_documento,
            'error' => $error,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Lists all NecesidadMaterial entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new NecesidadMaterialFilterModel();

        $form = $this->createForm(new NecesidadMaterialFilter(), $filter, array(
            'action' => $this->generateUrl('necesidadmaterial'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:NecesidadMaterial')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:NecesidadMaterial')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaBodegaBundle:NecesidadMaterial:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    public function procesarNecesidadAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $necesidadMaterial = $em->getRepository('BusetaBodegaBundle:NecesidadMaterial')->find($id);

        if (!$necesidadMaterial) {
            throw $this->createNotFoundException('Unable to find NecesidadMaterial entity.');
        }

        $fecha =  new \DateTime();

        $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($necesidadMaterial->getAlmacen());
        $tercero = $em->getRepository('BusetaBodegaBundle:Tercero')->find($necesidadMaterial->getTercero());

        //Registro los datos del nuevo PedidoCompra que se crear al procesar la NecesidadMaterial
        $pedidoCompra = new PedidoCompra();
        $pedidoCompra->setNumeroDocumento($necesidadMaterial->getNumeroDocumento());
        $pedidoCompra->setConsecutivoCompra($necesidadMaterial->getConsecutivoCompra());
        $pedidoCompra->setTercero($tercero);
        $pedidoCompra->setFechaPedido($necesidadMaterial->getFechaPedido());
        $pedidoCompra->setAlmacen($almacen);
        $pedidoCompra->setMoneda($necesidadMaterial->getMoneda());
        $pedidoCompra->setFormaPago($necesidadMaterial->getFormaPago());
        $pedidoCompra->setCondicionesPago($necesidadMaterial->getCondicionesPago());
        $pedidoCompra->setEstadoDocumento($necesidadMaterial->getEstadoDocumento());
        $pedidoCompra->setImporteTotal($necesidadMaterial->getImporteTotal());
        $pedidoCompra->setImporteTotalLineas($necesidadMaterial->getImporteTotalLineas());
        $pedidoCompra->setCreated(new \DateTime());

        $em->persist($pedidoCompra);
        $em->flush();

        //Registro los datos de las líneas del PedidoCompra
        foreach ($necesidadMaterial->getNecesidadMaterialLineas() as $linea) {
            $registroCompraLinea = new PedidoCompraLinea();
            $registroCompraLinea->setPedidoCompra($pedidoCompra);
            $registroCompraLinea->setLinea($linea->getLinea());
            $registroCompraLinea->setProducto($linea->getProducto());
            $registroCompraLinea->setCantidadPedido($linea->getCantidadPedido());
            $registroCompraLinea->setUom($linea->getUom());
            $registroCompraLinea->setPrecioUnitario($linea->getPrecioUnitario());
            $registroCompraLinea->setImpuesto($linea->getImpuesto());
            $registroCompraLinea->setMoneda($linea->getMoneda());
            $registroCompraLinea->setPorcientoDescuento($linea->getPorcientoDescuento());
            $registroCompraLinea->setImporteLinea($linea->getImporteLinea());

            $em->persist($registroCompraLinea);
            $em->flush();
        }

        $necesidadMaterial->setDeleted(true);
        $em->persist($necesidadMaterial);
        $em->flush();

        return $this->redirect($this->generateUrl('necesidadmaterial'));
    }

    /**
     * Creates a new NecesidadMaterial entity.
     *
     * @Route("/create", name="necesidadmateriales_necesidadmaterial_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $necesidadmaterialModel = new NecesidadMaterialModel();
        $form = $this->createCreateForm($necesidadmaterialModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $entity = $necesidadmaterialModel->getEntityData();

                $em->persist($entity);
                $em->flush();

                // Creando nuevamente el formulario con los datos actualizados de la entidad
                $form = $this->createEditForm(new NecesidadMaterialModel($entity));
                $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/form_template.html.twig', array(
                    'form'   => $form->createView(),
                ));

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
                ), 201);
            } catch (\Exception $e) {
                $logger->addCritical(sprintf(
                    $trans->trans('', array(), 'BusetaBodegaBundle') . '. Detalles: %s',
                    $e->getMessage()
                ));

                return new JsonResponse(array(
                    'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Registro de Compra'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/form_template.html.twig', array(
            'form'     => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a NecesidadMaterial entity.
     *
     * @param NecesidadMaterialModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NecesidadMaterialModel $entity)
    {
        $form = $this->createForm('bodega_necesidad_material', $entity, array(
            'action' => $this->generateUrl('necesidadmateriales_necesidadmaterial_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new NecesidadMaterial entity.
     *
     * @Route("/new", name="necesidadmateriales_necesidadmaterial_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $form   = $this->createCreateForm(new NecesidadMaterialModel());

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $json = array();
        $precioSalida = 0;

        foreach ($productos as $p) {
            foreach ($p->getPrecioProducto() as $precios) {
                if ($precios->getActivo()) {
                    $precioSalida = ($precios->getPrecio());
                }
            }

            $json[$p->getId()] = array(
                'nombre' => $p->getNombre(),
                'precio_salida' => $precioSalida,
            );
        }

        return $this->render('@BusetaBodega/NecesidadMaterial/new.html.twig', array(
            'form'   => $form->createView(),
            'json'   => json_encode($json),
        ));
    }

    /**
     * Finds and displays a NecesidadMaterial entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:NecesidadMaterial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NecesidadMaterial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:NecesidadMaterial:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing NecesidadMaterial entity.
     *
     * @Route("/{id}/edit", name="necesidadmateriales_necesidadmaterial_edit", methods={"GET"}, options={"expose":true})
     */
    public function editAction(NecesidadMaterial $necesidadmaterial)
    {
        $editForm = $this->createEditForm(new NecesidadMaterialModel($necesidadmaterial));
        $deleteForm = $this->createDeleteForm($necesidadmaterial->getId());

        return $this->render('BusetaBodegaBundle:NecesidadMaterial:edit.html.twig', array(
            'entity'        => $necesidadmaterial,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a NecesidadMaterial entity.
     *
     * @param NecesidadMaterialModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(NecesidadMaterialModel $entity)
    {
        $form = $this->createForm('bodega_necesidad_material', $entity, array(
            'action' => $this->generateUrl('necesidadmateriales_necesidadmaterial_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing NecesidadMaterial entity.
     *
     * @Route("/{id}/update", name="necesidadmateriales_necesidadmaterial_update", methods={"POST","PUT"}, options={"expose":true})
     */
    public function updateAction(Request $request, NecesidadMaterial $necesidadmaterial)
    {
        $necesidadmaterialModel = new NecesidadMaterialModel($necesidadmaterial);
        $editForm = $this->createEditForm($necesidadmaterialModel);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $necesidadmaterial->setModelData($necesidadmaterialModel);
                $em->flush();

                $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/form_template.html.twig', array(
                    'form'     => $editForm->createView(),
                ));

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.update.success', array(), 'BusetaBodegaBundle')
                ), 202);
            } catch (\Exception $e) {
                $logger->addCritical(sprintf(
                    $trans->trans('messages.update.success', array(), 'BusetaBodegaBundle'). '. Detalles: %s',
                    $e->getMessage()
                ));

                new JsonResponse(array(
                    'message' => $trans->trans('messages.update.error.%entidad%', array('entidad' => 'Registro de Compra'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBodega/NecesidadMaterial/form_template.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Edits an existing NecesidadMaterial entity.
     */
    /*public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:NecesidadMaterial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NecesidadMaterial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setCreated($entity->getCreated());
            $entity->setUpdated(new \DateTime());
            $em->flush();

            return $this->redirect($this->generateUrl('necesidadmaterial_show', array('id' => $id)));
        }

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $json = array();

        foreach ($productos as $p) {
            $json[$p->getId()] = array(
                'nombre' => $p->getNombre(),
                'precio_salida' => $p->getPrecioSalida(),
            );
        }

        return $this->render('BusetaBodegaBundle:NecesidadMaterial:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'json'   => json_encode($json),
        ));
    }*/

    /**
     * Deletes a NecesidadMaterial entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:NecesidadMaterial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NecesidadMaterial entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('necesidadmaterial'));
    }

    /**
     * Creates a form to delete a NecesidadMaterial entity by id.
     *
     * @param mixed $id The entity id
     *º
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('necesidadmaterial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
