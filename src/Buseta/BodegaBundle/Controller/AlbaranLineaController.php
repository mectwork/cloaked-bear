<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Albaran;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\AlbaranLinea;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AlbaranLineaController
 * @package Buseta\BodegaBundle\Controller
 *
 * @Route("/albaran_linea")
 */
class AlbaranLineaController extends Controller
{
    /**
     * @param Albaran $albaran
     * @return Response
     *
     * @Route("/list/{albaran}", name="albaran_lineas_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("albaran", options={"mapping":{"albaran":"id"}})
     */
    public function listAction(Albaran $albaran, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:AlbaranLinea')
            ->findAllByAlbaranId($albaran->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                5
            );

        return $this->render('@BusetaBodega/Albaran/Linea/list_template.html.twig', array(
            'entities' => $entities,
            'albaran' => $albaran,
        ));
    }

    /**
     * @param Albaran $albaran
     * @param Request $request
     *
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/{albaran}", name="albaran_lineas_new_modal", methods={"GET","POST"}, options={"expose":true})
     */
    public function newModalAction(Albaran $albaran, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('buseta_albaran.linea.handler');
        $handler->bindData($albaran);

        $handler->setRequest($request);

        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaBodega/Albaran/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaBodega/Albaran/Linea/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Albarán'), 'BusetaBodegaBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaBodega/Albaran/Linea/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    public function create_compraAction(Request $request)
    {
        $entity = new AlbaranLinea();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Finds and displays a AlbaranLinea entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:AlbaranLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AlbaranLinea entity.');
        }

        return $this->render('BusetaBodegaBundle:AlbaranLinea:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Lists all AlbaranLinea entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:AlbaranLinea')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            5,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaBodegaBundle:AlbaranLinea:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to edit an existing AlbaranLinea entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:AlbaranLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AlbaranLinea entity.');
        }

        //$linea = $this->createForm(new PedidoCompraLineaType());

        $editForm = $this->createEditForm($entity);

        $em = $this->getDoctrine()->getManager();

        return $this->render('BusetaBodegaBundle:AlbaranLinea:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            //'linea'       => $linea->createView(),
        ));
    }

    /**
     * Creates a form to edit a PedidoCompra entity.
     *
     * @param PedidoCompra $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(AlbaranLinea $entity)
    {
        $form = $this->createForm('bodega_albaran_type', $entity, array(
            'action' => $this->generateUrl('albaran_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing AlbaranLinea entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:AlbaranLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AlbaranLinea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pedidocompra_show', array('id' => $id)));
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

        return $this->render('BusetaBodegaBundle:AlbaranLinea:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'json'   => json_encode($json),
        ));
    }
}
