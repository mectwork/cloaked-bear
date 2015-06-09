<?php

namespace Buseta\BusesBundle\Controller;

use Buseta\BusesBundle\Entity\Autobus;

use Buseta\BusesBundle\Form\Model\FiltroModel;
use Buseta\BusesBundle\Form\Model\InformacionExtraModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * AutobusExtra controller.
 *
 * @Route("/autobus")
 */
class AutobusExtraController extends Controller
{

    /**
     * Displays a form to create a new Autobus entity.
     *
     * @Route("/{id}/extra/new", name="autobuses_autobus_informacionextra_new", methods={"GET"}, options={"expose":true})
     */
    public function newExtraAction(Autobus $autobus)
    {
        $form   = $this->createInformacionExtraEditForm(new InformacionExtraModel($autobus));

        return $this->render('@BusetaBuses/Autobus/form_template_informacion_extra.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param InformacionExtraModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createInformacionExtraEditForm(InformacionExtraModel $entity)
    {
        $form = $this->createForm('buses_autobus_informacion_extra', $entity, array(
            'action' => $this->generateUrl('autobuses_autobus_informacionextra_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Autobus entity.
     *
     * @Route("/extra/{id}/update", name="autobuses_autobus_informacionextra_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateInformacionExtraAction(Request $request, Autobus $autobus)
    {
        $extraModel = new InformacionExtraModel($autobus);
        $editForm = $this->createInformacionExtraEditForm($extraModel);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $autobus->setModelDataInformacionExtra($extraModel);
                $em->persist($autobus);
                $em->flush();

                $editForm = $this->createInformacionExtraEditForm(new InformacionExtraModel($autobus));
                $renderView = $this->renderView('@BusetaBuses/Autobus/form_template_informacion_extra.html.twig', array(
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
                    'message' => $trans->trans('messages.update.error.%key%', array('key' => 'Informacion Extra del Autobus'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBuses/Autobus/form_template_informacion_extra.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }
}
