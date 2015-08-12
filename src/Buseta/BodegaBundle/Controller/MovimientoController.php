<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Form\Filter\MovimientoFilter;
use Buseta\BodegaBundle\Form\Model\MovimientoFilterModel;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Form\Type\MovimientosProductosType;
use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Form\Type\MovimientoType;
use Buseta\BodegaBundle\Extras\FuncionesExtras;

/**
 * Movimiento controller.
 */
class MovimientoController extends Controller
{
    /**
     * Updated automatically select AlmacenDestino when change select AlmacenOrigen.
     */
    public function select_almacenOrigen_almacenDestinoAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();
//        $almacenDestino = $em->getRepository('BusetaBodegaBundle:Bodega')->findBy(array(
//            'id' => $request->query->get('almacenOrigen_id')
//        ));

        $almacenDestino = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();

        $json = array();
        foreach ($almacenDestino as $almacenDestino) {
            if ($almacenDestino->getId() != $request->query->get('almacenOrigen_id')) {
                $json[] = array(
                    'id' => $almacenDestino->getId(),
                    'valor' => $almacenDestino->getNombre(),
                );
            }
        }

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    public function create_movimientoAction(Request $request)
    {
        $entity = new MovimientosProductos();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Lists all Movimiento entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new MovimientoFilterModel();

        $form = $this->createForm(new MovimientoFilter(), $filter, array(
            'action' => $this->generateUrl('movimiento'),
        ));

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Movimiento')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Movimiento')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:Movimiento:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Movimiento entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Movimiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $fechaMovimiento = new \DateTime();

            $request = $this->get('request');
            $datos = $request->request->get('buseta_bodegabundle_movimiento');

            //Comparar la existencia de cantidad de productos disponibles en el almacen
            //a partir de la solicitud de movimiento de productos entre almacenes

            $idAlmacenOrigen  = $datos['almacenOrigen'];
            $idAlmacenDestino = $datos['almacenDestino'];

            $movimientos = $datos['movimientos_productos'];

            $cantidadDisponible = 0;

            foreach ($movimientos as $movimiento) {
                $idProducto = $movimiento['producto'];

                $producto           = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
                $almacen            = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
                $cantidadProducto   = $movimiento['cantidad'];

                $fe = new FuncionesExtras();
                $cantidadDisponible = $fe->comprobarCantProductoAlmacen($producto, $almacen, $cantidadProducto, $em);

                //Comprobar la existencia del producto en la bodega seleccionada
                if ($cantidadDisponible == 'No existe') {
                    //Volver al menu de de crear nuevo Movimiento
                    $movimientosProductos = $this->createForm(new MovimientosProductosType());

                    $form   = $this->createCreateForm($entity);
                    $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
                    $bodega   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);

                    $form->addError(new FormError("El producto '".$producto->getNombre()."' no existe en la bodega seleccionada"));

                    return $this->render('BusetaBodegaBundle:Movimiento:new.html.twig', array(
                        'entity' => $entity,
                        'movimientosProductos' => $movimientosProductos->createView(),
                        'form'   => $form->createView(),
                    ));
                }
                //Si no existe la cantidad solicitada en el almacen del producto seleccionado
                elseif ($cantidadDisponible < 0) {
                    //Volver al menu de de crear nuevo Movimiento
                    $movimientosProductos = $this->createForm(new MovimientosProductosType());

                    $form   = $this->createCreateForm($entity);
                    $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
                    $bodega   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);

                    $form->addError(new FormError("No existe en la bodega '".$bodega->getNombre()."' la cantidad de productos solicitados para el producto: ".$producto->getNombre()));

                    return $this->render('BusetaBodegaBundle:Movimiento:new.html.twig', array(
                        'entity' => $entity,
                        'movimientosProductos' => $movimientosProductos->createView(),
                        'form'   => $form->createView(),
                    ));
                }
                //Si sí existe la cantidad del producto en la bodega seleccionada
                else {
                    //Actualizar Bitácora - AlmacenOrigen
                    $bitacora = new BitacoraAlmacen();
                    $bitacora->setProducto($producto);
                    $bitacora->setFechaMovimiento($fechaMovimiento);
                    $origen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
                    $bitacora->setAlmacen($origen);
                    $bitacora->setCantMovida($movimiento['cantidad']);
                    $bitacora->setTipoMovimiento('M-');
                    $em->persist($bitacora);
                    $em->flush();

                    //Actualizar Bitácora - AlmacenDestino
                    $bitacora = new BitacoraAlmacen();
                    $bitacora->setProducto($producto);
                    $bitacora->setFechaMovimiento($fechaMovimiento);
                    $destino = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenDestino);
                    $bitacora->setAlmacen($destino);
                    $bitacora->setCantMovida($movimiento['cantidad']);
                    $bitacora->setTipoMovimiento('M+');
                    $em->persist($bitacora);
                    $em->flush();

                    $almacenOrigen    = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
                    $almacenDestino   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenDestino);

                    //Persistimos los movimientos
                    $entity->setCreatedBy($this->getUser()->getUsername());
                    $entity->setMovidoBy($this->getUser()->getUsername());
                    $entity->setAlmacenOrigen($almacenOrigen);
                    $entity->setAlmacenDestino($almacenDestino);
                    $entity->setFechaMovimiento($fechaMovimiento);
                    $em->persist($entity);
                    $em->flush();
                }
            }

            return $this->redirect($this->generateUrl('movimiento_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Movimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Movimiento entity.
     *
     * @param Movimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Movimiento $entity)
    {
        $form = $this->createForm(new MovimientoType(), $entity, array(
            'action' => $this->generateUrl('movimiento_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Movimiento entity.
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $paginator = $this->get('knp_paginator');

        $productos = $paginator->paginate(
            $productos,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        $entity = new Movimiento();

        $movimientosProductos = new MovimientosProductos();
        $movimientosProductos = $this->createForm(new MovimientosProductosType());

        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:Movimiento:new.html.twig', array(
            'entity' => $entity,
            'movimientosProductos' => $movimientosProductos->createView(),
            'productos' => $productos,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Movimiento entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Movimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Movimiento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Movimiento entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Movimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movimiento entity.');
        }

        $movimientosProductos = $this->createForm(new MovimientosProductosType());

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Movimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'movimientosProductos'   => $movimientosProductos->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Movimiento entity.
     *
     * @param Movimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Movimiento $entity)
    {
        $form = $this->createForm('buseta_bodegabundle_movimiento', $entity, array(
            'action' => $this->generateUrl('movimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Movimiento entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Movimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('movimiento_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Movimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Movimiento entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:Movimiento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Movimiento entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Ha sido eliminado satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('logger')->addCritical(
                    sprintf('Ha ocurrido un error eliminando un movimiento de bodega. Detalles: %s',
                        $e->getMessage()
                    ));
            }
        }

        return $this->redirect($this->generateUrl('movimiento'));
    }

    /**
     * Creates a form to delete a Movimiento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movimiento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}
