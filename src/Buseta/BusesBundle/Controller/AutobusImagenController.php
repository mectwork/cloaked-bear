<?php

namespace Buseta\BusesBundle\Controller;

use Buseta\BusesBundle\Entity\Autobus;

use Buseta\BusesBundle\Form\Model\ImagenModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * AutobusImagen controller.
 *
 * @Route("/autobus")
 */
class AutobusImagenController extends Controller
{
    /**
     * Edits an existing Autobus entity.
     *
     * @Route("/imagenes/{id}/update", name="autobuses_autobus_imagenes_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, Autobus $autobus)
    {
        $model = new ImagenModel($autobus);
        $editForm = $this->createEditForm($model);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $autobus->setModelDataImagen($model);
                $em->persist($autobus);
                $em->flush();

                $editForm = $this->createEditForm(new ImagenModel($autobus));
                $renderView = $this->renderView('@BusetaBuses/Autobus/form_template_imagenes.html.twig', array(
                    'form'     => $editForm->createView(),
                    'entity' => $autobus,
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
                    'message' => $trans->trans('messages.update.error.%key%', array('key' => 'Imagen del Autobus'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBuses/Autobus/form_template_imagenes.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Displays a form to create a new Autobus entity.
     *
     * @Route("/{id}/imagenes/new", name="autobuses_autobus_imagenes_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction(Autobus $autobus)
    {
        $form   = $this->createEditForm(new ImagenModel($autobus));

        return $this->render('@BusetaBuses/Autobus/form_template_imagenes.html.twig', array(
            'form'   => $form->createView(),
            'entity' => $autobus,
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param ImagenModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ImagenModel $entity)
    {
        $form = $this->createForm('buses_autobus_imagenes', $entity, array(
            'action' => $this->generateUrl('autobuses_autobus_imagenes_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

}
