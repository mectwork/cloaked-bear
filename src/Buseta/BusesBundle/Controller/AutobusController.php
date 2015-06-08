<?php

namespace Buseta\BusesBundle\Controller;

use Buseta\BusesBundle\Entity\ArchivoAdjunto;
use Buseta\BusesBundle\Form\Filter\AutobusFilter;
use Buseta\BusesBundle\Form\Model\AutobusBasicoModel;
use Buseta\BusesBundle\Form\Model\AutobusFilterModel;
use Buseta\BusesBundle\Form\Model\FileModel;
use Buseta\BusesBundle\Form\Model\InformacionExtraModel;
use Buseta\BusesBundle\Form\Type\ArchivoAdjuntoType;
use Buseta\BusesBundle\Form\Type\KilometrajeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BusesBundle\Form\Type\AutobusType;
use Buseta\BusesBundle\Form\Filtro\BusquedaAutobusType;
use Buseta\BusesBundle\Entity\Autobus;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Autobus controller.
 *
 * @Route("/autobus")
 */
class AutobusController extends Controller
{

    /**
     * Lists all Autobuses entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new AutobusFilterModel();

        $form = $this->createForm(new AutobusFilter(), $filter, array(
            'action' => $this->generateUrl('autobus'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBusesBundle:Autobus')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBusesBundle:Autobus')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaBusesBundle:Autobus:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Autobus entity.
     *
     * @Route("/create", name="autobuses_autobus_basicos_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $basicosModel = new AutobusBasicoModel();
        $form = $this->createCreateForm($basicosModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $entity = $basicosModel->getEntityData();
                $em->persist($entity);
                $em->flush();

                // Creando nuevamente el formulario con los datos actualizados de la entidad
                $form = $this->createEditForm(new AutobusBasicoModel($entity));
                $renderView = $this->renderView('@BusetaBuses/Autobus/form_template.html.twig', array(
                    'form'   => $form->createView(),
                ));

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.create.success', array(), 'BusetaBusesBundle')
                ), 201);
            } catch (\Exception $e) {
                $logger->addCritical(sprintf(
                    $trans->trans('', array(), 'BusetaBusesBundle') . '. Detalles: %s',
                    $e->getMessage()
                ));

                return new JsonResponse(array(
                    'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Datos Basicos de Autobus'), 'BusetaBusesBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBuses/Autobus/form_template.html.twig', array(
            'form'     => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a Autobus entity.
     *
     * @param AutobusBasicoModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AutobusBasicoModel $entity)
    {
        $form = $this->createForm('buses_autobus_basico', $entity, array(
            'action' => $this->generateUrl('autobuses_autobus_basicos_create'),
            'method' => 'POST',
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

    /**
     * Displays a form to create a new Autobus entity.
     *
     * @Route("/new", name="autobuses_autobus_basicos_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $form   = $this->createCreateForm(new AutobusBasicoModel());

        return $this->render('BusetaBusesBundle:Autobus:new.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

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
     * @param AutobusBasicoModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(AutobusBasicoModel $entity)
    {
        $form = $this->createForm('buses_autobus_basico', $entity, array(
            'action' => $this->generateUrl('autobus_basico_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
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
     * @Route("/{id}/update", name="autobus_basico_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, Autobus $autobus)
    {
        $autobusModel = new AutobusBasicoModel($autobus);
        $editForm = $this->createEditForm($autobusModel);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $autobus->setModelData($autobusModel);
                $em->flush();

                $editForm = $this->createEditForm(new AutobusBasicoModel($autobus));
                $renderView = $this->renderView('@BusetaBuses/Autobus/form_template.html.twig', array(
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
                    'message' => $trans->trans('messages.update.error.%key%', array('key' => 'Autobus Basico'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBuses/Autobus/form_template.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

}
