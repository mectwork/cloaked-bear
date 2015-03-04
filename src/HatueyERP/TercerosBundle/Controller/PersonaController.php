<?php

namespace HatueyERP\TercerosBundle\Controller;


use HatueyERP\TercerosBundle\Entity\Persona;
use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class PersonaController
 * @package HatueyERP\TercerosBundle\Controller
 *
 * @Route("/persona")
 */
class PersonaController extends Controller
{
    /**
     * @param Request $request
     * @internal $tercero
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/new/{tercero}", name="terceros_persona_new", methods={"GET"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newAction(Request $request, Tercero $tercero)
    {
        $handler = $this->get('hatueyerp_terceros.persona.handler');
        $handler->bindData($tercero);

        return $this->render('@HatueyERPTerceros/Persona/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));
    }

    /**
     * @param Request $request
     * @internal $tercero
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/create/{tercero}", name="terceros_persona_create", methods={"POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function createAction(Request $request, Tercero $tercero)
    {
        $handler    = $this->get('hatueyerp_terceros.persona.handler');
        $trans      = $this->get('translator');

        $handler->bindData($tercero);

        $handler->setRequest($request);
        if($handler->handle()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Persona/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'HatueyERPTercerosBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Persona/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Persona'), 'HatueyERPTercerosBundle')
            ), 500);
        }

        return $this->render('@HatueyERPTerceros/Persona/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));
    }

    /**
     * @param Request $request
     * @internal $tercero
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/{id}/update/{tercero}", name="terceros_persona_update", methods={"POST","PUT"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function updateAction(Request $request, Persona $persona, Tercero $tercero)
    {
        $handler    = $this->get('hatueyerp_terceros.persona.handler');
        $trans      = $this->get('translator');

        $handler->bindData($tercero, $persona);

        $handler->setRequest($request);
        if($handler->handle()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Persona/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.update.success', array(), 'HatueyERPTercerosBundle')
            ), 202);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@HatueyERPTerceros/Persona/form_template.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.update.error.%key%', array('key' => 'Persona'), 'HatueyERPTercerosBundle')
            ), 500);
        }

        $renderView = $this->renderView('@HatueyERPTerceros/Persona/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * @param Request $request
     * @internal $tercero
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/{id}/edit/{tercero}", name="terceros_persona_edit", methods={"GET"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function editAction(Request $request, Persona $persona, Tercero $tercero)
    {
        $handler = $this->get('hatueyerp_terceros.persona.handler');
        $handler->bindData($tercero, $persona);

        return $this->render('@HatueyERPTerceros/Persona/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @Route("/edad", name="terceros_persona_edad", methods={"GET"}, options={"expose":true})
     */
    public function edadAction(Request $request)
    {
        $fechaNacimiento = $request->query->get('fechaNacimiento');
        $edad = '';
        if ($fechaNacimiento) {
            $fechaActual = new \DateTime();
            $fechaNacimiento = date_create_from_format('d/m/Y', $fechaNacimiento);

            $diff = date_diff($fechaNacimiento, $fechaActual);
            $edad = $diff->y;
        }

        return new JsonResponse(array('edad' => $edad));
    }
} 