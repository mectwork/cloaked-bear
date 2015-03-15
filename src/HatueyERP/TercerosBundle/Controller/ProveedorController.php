<?php

namespace HatueyERP\TercerosBundle\Controller;

use HatueyERP\TercerosBundle\Entity\Proveedor;
use HatueyERP\TercerosBundle\Entity\Tercero;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ProveedorController
 * @package HatueyERP\TercerosBundle\Controller
 *
 * @Route("/proveedor")
 */
class ProveedorController extends Controller
{
    /**
     * @Route("/new/{tercero}", name="terceros_proveedor_new", methods={"GET"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newAction(Tercero $tercero)
    {
        $handler = $this->get('hatueyerp_terceros.proveedor.handler');
        $handler->bindData($tercero);

        return $this->render('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));
    }

    /**
     * @Route("/create/{tercero}", name="terceros_proveedor_create", methods={"POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function createAction(Tercero $tercero, Request $request)
    {
        $handler    = $this->get('hatueyerp_terceros.proveedor.handler');
        $trans      = $this->get('translator');

        $handler->bindData($tercero);

        $handler->setRequest($request);
        if($handler->handle()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'HatueyERPTercerosBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Proveedor'), 'HatueyERPTercerosBundle')
            ), 500);
        }

        $renderView = $this->renderView('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * @Route("/{id}/edit/{tercero}", name="terceros_proveedor_edit", methods={"GET"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function editAction(Tercero $tercero, Proveedor $cliente)
    {
        $handler = $this->get('hatueyerp_terceros.proveedor.handler');
        $handler->bindData($tercero, $cliente);

        return $this->render('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));
    }

    /**
     * @Route("/{id}/update/{tercero}", name="terceros_proveedor_update", methods={"PUT", "POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function updateAction(Tercero $tercero, Proveedor $proveedor, Request $request)
    {
        $handler    = $this->get('hatueyerp_terceros.proveedor.handler');
        $trans      = $this->get('translator');

        $handler->bindData($tercero, $proveedor);

        $handler->setRequest($request);
        if($handler->handle()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.update.success', array(), 'HatueyERPTercerosBundle')
            ), 202);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.update.error.%key%', array('key' => 'Proveedor'), 'HatueyERPTercerosBundle')
            ), 500);
        }

        $renderView = $this->renderView('@HatueyERPTerceros/Proveedor/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }
} 