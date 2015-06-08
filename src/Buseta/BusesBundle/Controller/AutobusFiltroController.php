<?php

namespace Buseta\BusesBundle\Controller;

use Buseta\BusesBundle\Entity\Autobus;

use Buseta\BusesBundle\Form\Model\FiltroModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * AutobusFiltro controller.
 *
 * @Route("/autobus")
 */
class AutobusFiltroController extends Controller
{
    /**
     * Edits an existing Autobus entity.
     *
     * @Route("/filtro/{id}/update", name="autobuses_autobus_filtro_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, Autobus $autobus)
    {
        $model = new FiltroModel($autobus);
        $editForm = $this->createEditForm($model);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $autobus->setModelDataFiltro($model);
                $em->persist($autobus);
                $em->flush();

                $editForm = $this->createEditForm(new FiltroModel($autobus));
                $renderView = $this->renderView('@BusetaBuses/Autobus/form_template_filtros.html.twig', array(
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
                    'message' => $trans->trans('messages.update.error.%key%', array('key' => 'Filtro del Autobus'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBuses/Autobus/form_template_filtros.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Displays a form to create a new Autobus entity.
     *
     * @Route("/{id}/filtro/new", name="autobuses_autobus_filtro_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction(Autobus $autobus)
    {
        $form   = $this->createEditForm(new FiltroModel($autobus));

        return $this->render('@BusetaBuses/Autobus/form_template_filtros.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param FiltroModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(FiltroModel $entity)
    {
        $form = $this->createForm('buses_autobus_filtro', $entity, array(
            'action' => $this->generateUrl('autobuses_autobus_filtro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

}
