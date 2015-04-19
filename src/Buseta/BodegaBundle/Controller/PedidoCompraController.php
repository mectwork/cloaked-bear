<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Entity\PedidoCompraLinea;
use Buseta\BodegaBundle\Form\Filter\PedidoCompraFilter;
use Buseta\BodegaBundle\Form\Model\PedidoCompraFilterModel;
use Buseta\BodegaBundle\Form\Model\PedidoCompraModel;
use Buseta\BodegaBundle\Form\Type\PedidoCompraLineaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\PedidoCompra;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * PedidoCompra controller.
 *
 * @Route("/pedidocompra")
 */
class PedidoCompraController extends Controller
{
    /**
     * Lists all PedidoCompra entities.
     *
     * @Route("/", name="pedidocompra")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new PedidoCompraFilterModel();

        $form = $this->createForm(new PedidoCompraFilter(), $filter, array(
            'action' => $this->generateUrl('pedidocompra'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:PedidoCompra')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:PedidoCompra')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaBodegaBundle:PedidoCompra:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}/procesarRegistro", name="procesarRegistro")
     * @Method("GET")
     */
    public function procesarRegistroAction(PedidoCompra $pedidoCompra)
    {
        $em = $this->getDoctrine()->getManager();

        //Cambia el estado de Borrador a Procesado
        $pedidoCompra->setEstadoDocumento('PR');

        try {
            $em->persist($pedidoCompra);
            $em->flush();
        } catch (\Exception $e) {
            $this->get('logger')->addCritical(sprintf('Ha ocurrido un error actualizando el estado del documento. Detalles: %s', $e->getMessage()));
            $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error actualizando el estado del documento.');
        }

        return $this->redirect($this->generateUrl('pedidocompra'));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/{id}/completarRegistro", name="completarRegistro")
     * @Method("GET")
     */
    public function completarRegistroAction(PedidoCompra $pedidoCompra)
    {
        $em         = $this->getDoctrine()->getManager();
        $logger     = $this->get('logger');
        $session    = $this->get('session');
        $validator  = $this->get('validator');
        $error      = false;

        if (($errors = $validator->validate($pedidoCompra, 'on_complete')) && count($errors) > 0) {
            foreach ($errors as $e) {
                /** @var ConstraintViolation $e */
                $session->getFlashBag()->add('danger', $e->getMessage());
            }
            $error = true;
        }

        if (!$error) {
            //Cambia el estado de Procesado a Completado
            $pedidoCompra->setEstadoDocumento('CO');
            try {
                $em->persist($pedidoCompra);
                $em->flush();
            } catch (\Exception $e) {
                $logger->addCritical(sprintf('Ha ocurrido un error actualizando el estado del documento. Detalles: %s', $e->getMessage()));
                $session->getFlashBag()->add('danger', 'Ha ocurrido un error actualizando el estado del documento.');

                $error = true;
            }
        }

        if (!$error) {
            $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($pedidoCompra->getAlmacen());
            $tercero = $em->getRepository('BusetaBodegaBundle:Tercero')->find($pedidoCompra->getTercero());

            //registro los datos del nuevo albarán que se crear al procesar el pedido
            $albaran = new Albaran();
            $albaran->setEstadoDocumento('BO');
            $albaran->setAlmacen($almacen);
            $albaran->setConsecutivoCompra($pedidoCompra->getConsecutivoCompra());
            $albaran->setTercero($tercero);
            $albaran->setCreated(new \DateTime());

            $em->persist($albaran);
            $em->flush();

            //registro los datos de las líneas del albarán
            foreach ($pedidoCompra->getPedidoCompraLineas() as $linea) {
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
        }

        return $this->redirect($this->generateUrl('pedidocompra'));
    }

    /**
     * Creates a new PedidoCompra entity.
     *
     * @Route("/create", name="pedidocompra_create", options={"expose": true})
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $pedidocompraModel = new PedidoCompraModel();
        $form = $this->createCreateForm($pedidocompraModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $entity = $pedidocompraModel->getEntityData();

                $em->persist($entity);
                $em->flush();

                // Creando nuevamente el formulario con los datos actualizados de la entidad
                $form = $this->createEditForm(new PedidoCompraModel($entity));
                $renderView = $this->renderView('@BusetaBodega/PedidoCompra/form_template.html.twig', array(
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

        $renderView = $this->renderView('@BusetaBodega/PedidoCompra/form_template.html.twig', array(
            'form'     => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a PedidoCompra entity.
     *
     * @param PedidoCompraModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PedidoCompraModel $entity)
    {
        $form = $this->createForm('bodega_pedido_compra', $entity, array(
            'action' => $this->generateUrl('pedidocompra_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new PedidoCompra entity.
     *
     * @Route("/new", name="pedidocompra_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $form   = $this->createCreateForm(new PedidoCompraModel());

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

        return $this->render('@BusetaBodega/PedidoCompra/new.html.twig', array(
            'form'   => $form->createView(),
            'json'   => json_encode($json),
        ));
    }

    /**
     * Finds and displays a PedidoCompra entity.
     *
     * @Route("/{id}/show", name="pedidocompra_show")
     * @Method("GET")
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
     * @Route("/{id}/edit", name="pedidocompra_edit", options={"expose": true})
     * @Method("GET")
     */
    public function editAction(PedidoCompra $pedidocompra)
    {
        $editForm = $this->createEditForm(new PedidoCompraModel($pedidocompra));
        $deleteForm = $this->createDeleteForm($pedidocompra->getId());

        return $this->render('BusetaBodegaBundle:PedidoCompra:edit.html.twig', array(
            'entity'        => $pedidocompra,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a PedidoCompra entity.
     *
     * @param PedidoCompraModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(PedidoCompraModel $entity)
    {
        $form = $this->createForm('bodega_pedido_compra', $entity, array(
            'action' => $this->generateUrl('pedidocompra_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing PedidoCompra entity.
     *
     * @Route("/{id}/update", name="pedidocompra_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, PedidoCompra $pedidocompra)
    {
        $pedidocompraModel = new PedidoCompraModel($pedidocompra);
        $editForm = $this->createEditForm($pedidocompraModel);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $pedidocompra->setModelData($pedidocompraModel);
                $em->flush();

                $renderView = $this->renderView('@BusetaBodega/PedidoCompra/form_template.html.twig', array(
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

        $renderView = $this->renderView('@BusetaBodega/PedidoCompra/form_template.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Deletes a PedidoCompra entity.
     *
     * @Route("/{id}/delete", name="pedidocompra_delete", options={"expose": true})
     * @Method({"DELETE", "GET", "POST"})
     */
    public function deleteAction(PedidoCompra $pedidocompra, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($pedidocompra->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($pedidocompra);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Pedido Compra'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/PedidoCompra/delete_modal.html.twig', array(
            'entity' => $pedidocompra,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('pedidocompra'));
    }

    /**
     * Creates a form to delete a PedidoCompra entity by id.
     *
     * @param mixed $id The entity id
     *º
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedidocompra_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
