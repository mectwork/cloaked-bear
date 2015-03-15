<?php

namespace HatueyERP\TercerosBundle\Controller;

use HatueyERP\TercerosBundle\Entity\Direccion;
use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Type\DireccionAjaxType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class DireccionController
 * @package HatueyERP\TercerosBundle\Controller
 * @author: Dundivet <dundivet@emailn.de>
 *
 * @Route("/direccion")
 */
class DireccionController extends Controller
{
    /**
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/list/{tercero}", name="terceros_direccion_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function listAction(Tercero $tercero, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('HatueyERPTercerosBundle:Direccion')
            ->findAllByTerceroId($tercero->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@HatueyERPTerceros/Tercero/Direccion/list_template.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/{tercero}", name="terceros_direccion_new_modal", methods={"GET","POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newModalAction(Tercero $tercero, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('hatueyerp_terceros.direccion.handler');
        $handler->bindData($tercero);

        $handler->setRequest($request);
        if($handler->handle()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Tercero/Direccion/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'HatueyERPTercerosBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Tercero/Direccion/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Direccion'), 'HatueyERPTercerosBundle')
            ), 500);
        }

        $renderView = $this->renderView('@HatueyERPTerceros/Tercero/Direccion/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * @param Tercero $tercero
     * @param Request $request
     *
     * @Route("/{id}/modal/create", name="terceros_direccion_modal_create", methods={"GET"}, options={"expose":true})
     */
    public function direccionModalCreateAction(Tercero $tercero, Request $request)
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/create/{tercero}", name="terceros_direccion_create_ajax", methods={"POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function createDireccionAjaxAction(Request $request)
    {
        $entity = new Direccion();

        $form = $this->createForm('hatueyerp_terceros_direccion_type', $entity);

        $form->submit($request);
        if ($form->isValid()) {

            $em = $this->get('doctrine.orm.entity_manager');
            try {

                $em->persist($entity);
                $em->flush();

                $data = array(
                    'success' => 'Se ha creado la dirección satisfactoriamente.',
                    'id' => $entity->getId(),
                );

                return new JsonResponse($data, 200);
            } catch (\Exception $e) {
                $this->get('logger')->error(
                    sprintf('Ha ocurrido un error inesperado creando una dirección. Detalles: %s',
                    $e->getMessage()
                ));

                $data = array(
                    'error' => 'Ha ocurrido un error inesperado creando una dirección.',
                );

                return new JsonResponse($data, 500);
            }
        }

        $data = array(
            'form' => $this->render('@HatueyERPTerceros/Tercero/Direccion/_direccion_form_ajax_template.html.twig', array(
                        'form' => $form->createView(),
                    ))
        );

        return new JsonResponse($data, 200);
    }

    /**
     * @return JsonResponse
     *
     * @Route("/direcciones.{_format}", name="terceros_direccion_getall_json", defaults={"_format":"json"}, requirements={"_format":"txt|json"}, options={"expose":true})
     */
    public function getAllAddressJSONAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $dirs = $em->getRepository('HatueyERPTercerosBundle:Direccion')->findAll();

        $data = array();
        foreach ($dirs as $d) {
            $data[] = array(
                'id' => $d->getId(),
                'value' => $d->__toString(),
            );
        }

        return new JsonResponse($data);
    }
}