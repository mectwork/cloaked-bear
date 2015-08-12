<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Form\Filter\AlbaranFilter;
use Buseta\BodegaBundle\Form\Model\AlbaranFilterModel;
use Buseta\BodegaBundle\Form\Model\AlbaranModel;
use Buseta\BodegaBundle\Form\Type\AlbaranLineaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Form\Filtro\BusquedaAlbaranType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Albaran controller.
 *
 * @Route("/albaran")
 */
class AlbaranController extends Controller
{
    /**
     * Lists all Albaran entities.
     *
     * @Route("/", name="albaran")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new AlbaranFilterModel();

        $form = $this->createForm(new AlbaranFilter(), $filter, array(
            'action' => $this->generateUrl('albaran'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Albaran')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Albaran')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:Albaran:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    public function procesarAlbaranAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $albaran = $em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

        if (!$albaran) {
            throw $this->createNotFoundException('Unable to find Albaran entity.');
        }

        //Cambia el estado de Borrador a Procesado
        $albaran->setEstadoDocumento('PR');
        $em->persist($albaran);
        $em->flush();

        return $this->redirect($this->generateUrl('albaran'));
    }

    public function completarAlbaranAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $albaran = $em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

        $albaranLineas = $em->getRepository('BusetaBodegaBundle:AlbaranLinea')->findBy(array(
            'albaran' => $albaran,
        ));


        foreach ($albaranLineas as $linea) {

            //Actualizar Bitácora
            $bitacora = new BitacoraAlmacen();
            $bitacora->setProducto($linea->getProducto());
            $bitacora->setCategoriaProducto($linea->getProducto()->getCategoriaProducto());
            $bitacora->setFechaMovimiento($albaran->getFechaMovimiento());
            $bitacora->setAlmacen($linea->getAlmacen());
            $bitacora->setCantMovida($linea->getCantidadMovida());
            $bitacora->setTipoMovimiento('V+');

            //Cambia el estado de Procesado a Completado
            $albaran->setEstadoDocumento('CO');

            $em->persist($bitacora);
            $em->flush();
        }

        //Cambia el estado de Procesado a Completado
        $albaran->setEstadoDocumento('CO');
        $em->persist($albaran);
        $em->flush();

        return $this->redirect($this->generateUrl('albaran'));
    }

    public function guardarAlbaranAction(Request $request)
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

        if ($request->query->get('estadoDocumento')) {
            $estadoDocumento = $request->query->get('estadoDocumento');
        } else {
            $error = "error";
        }

        if ($request->query->get('fechaMovimiento')) {
            $fechaMovimiento = $request->query->get('fechaMovimiento');

            //$fecha = new \DateTime('now');
            $date = '%s-%s-%s GMT-0';
            $fecha = explode("/", $fechaMovimiento);
            $d = $fecha[0];
            $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fechaMovimiento =  new \DateTime(sprintf($date, $y, $m, $d));
        } else {
            $error = "error";
        }

        if ($request->query->get('fechaContable')) {
            $fechaContable = $request->query->get('fechaContable');

            //$fecha = new \DateTime('now');
            $date = '%s-%s-%s GMT-0';
            $fecha = explode("/", $fechaContable);
            $d = $fecha[0];
            $m = $fecha[1];
            $fecha = explode(" ", $fecha[2]); //YYYY HH:MM
            $y = $fecha[0];
            $fechaContable =  new \DateTime(sprintf($date, $y, $m, $d));
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

        if ($request->query->get('numeroReferencia')) {
            $numeroReferencia = $request->query->get('numeroReferencia');
        } else {
            $error = "error";
        }

        if ($request->query->get('consecutivoCompra')) {
            $consecutivoCompra = $request->query->get('consecutivoCompra');
        } else {
            $error = "error";
        }

        $json = array(
            'error' => $error,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    public function select_albaran_ajaxAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();

        $linea = $request->query->get('linea');

        $json = array(
            'linea' => $linea,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Finds and displays a Albaran entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Albaran entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Albaran:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing Albaran entity.
     *
     * @Route("/{id}/edit", name="albarans_albaran_edit", methods={"GET"}, options={"expose":true})
     */
    public function editAction(Albaran $albaran)
    {
        $editForm = $this->createEditForm(new AlbaranModel($albaran));
        /*$deleteForm = $this->createDeleteForm($albaran->getId());*/

        return $this->render('BusetaBodegaBundle:Albaran:edit.html.twig', array(
            'entity'        => $albaran,
            'edit_form'     => $editForm->createView(),
            /*'delete_form'   => $deleteForm->createView(),*/
        ));
    }

    /**
     * Creates a form to edit a Albaran entity.
     *
     * @param AlbaranModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(AlbaranModel $entity)
    {
        $form = $this->createForm('bodega_albaran_type', $entity, array(
            'action' => $this->generateUrl('albarans_albaran_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Albaran entity.
     *
     * @Route("/{id}/update", name="albarans_albaran_update", methods={"POST","PUT"}, options={"expose":true})
     */
    public function updateAction(Request $request, Albaran $albaran)
    {
        $albaranModel = new AlbaranModel($albaran);
        $editForm = $this->createEditForm($albaranModel);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $albaran->setModelData($albaranModel);
                $em->flush();

                $renderView = $this->renderView('@BusetaBodega/Albaran/form_template.html.twig', array(
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
                    'message' => $trans->trans('messages.update.error.%entidad%', array('entidad' => 'Albarán'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBodega/Albaran/form_template.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a new Albaran entity.
     *
     * @Route("/create", name="albarans_albaran_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $albaranModel = new AlbaranModel();
        $form = $this->createCreateForm($albaranModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $entity = $albaranModel->getEntityData();

                $em->persist($entity);
                $em->flush();

                // Creando nuevamente el formulario con los datos actualizados de la entidad
                $form = $this->createEditForm(new AlbaranModel($entity));
                $renderView = $this->renderView('@BusetaBodega/Albaran/form_template.html.twig', array(
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
                    'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Albarán'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBodega/Albaran/form_template.html.twig', array(
            'form'     => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a Albaran entity.
     *
     * @param AlbaranModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AlbaranModel $entity)
    {
        $form = $this->createForm('bodega_albaran_type', $entity, array(
            'action' => $this->generateUrl('albarans_albaran_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Albaran entity.
     *
     * @Route("/new", name="albarans_albaran_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $form   = $this->createCreateForm(new AlbaranModel());

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

        return $this->render('@BusetaBodega/Albaran/new.html.twig', array(
            'form'   => $form->createView(),
            'json'   => json_encode($json),
        ));
    }

    /**
     * Deletes a Albaran entity.
     *
     * @Route("/{id}/delete", name="albaran_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(Albaran $albaran, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($albaran->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($albaran);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Albarán'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/Albaran/delete_modal.html.twig', array(
            'entity' => $albaran,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('albaran'));
    }

    /**
     * Creates a form to delete a Albaran entity by id.
     *
     * @param mixed $id The entity id
     *º
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('albaran_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
