<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\Reporte;
use Buseta\TallerBundle\Form\Filter\DiagnosticoFilter;
use Buseta\TallerBundle\Form\Model\DiagnosticoFilterModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\TallerBundle\Entity\Observacion;
use Buseta\TallerBundle\Form\Type\ObservacionType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ObservacionController
 * @package Buseta\TallerBundle\Controller
 *
 * @Route("/observacion")
 */
class ObservacionController extends Controller
{
    /**
     * @param Reporte $reporte
     * @return Response
     *
     * @Route("/list/{reporte}", name="reportes_observacion_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("reporte", options={"mapping":{"reporte":"id"}})
     */
    public function listAction(Reporte $reporte, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaTallerBundle:Observacion')
            ->findAllByReporteId($reporte->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaTaller/Reporte/Observacion/list_template.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function newModalObservacionAction(Request $request)
    {
        $form = $this->createForm(new ObservacionType(), null, array(
            'method' => 'POST',
            'action' => $this->generateUrl('observacion_new_modal')
        ));

        return $this->render('@BusetaTaller/Reporte/modal/modal_observacion.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function newModalObservacionDiagnosticoAction(Request $request)
    {
        $form = $this->createForm(new ObservacionType(), null, array(
            'method' => 'POST',
            'action' => $this->generateUrl('observacion_diagnostico_new_modal')
        ));

        return $this->render('@BusetaTaller/Diagnostico/modal/modal_observacion.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/{reporte}", name="reportes_observacion_new_modal", methods={"GET","POST"}, options={"expose":true})
     * @ParamConverter("reporte", options={"mapping":{"reporte":"id"}})
     */
    public function newModalAction(Reporte $reporte, Request $request)
    {

        $trans = $this->get('translator');
        $handler = $this->get('buseta_reporte.observacion.handler');
        $handler->bindData($reporte);

        $handler->setRequest($request);
        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaTaller/Reporte/Observacion/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaTallerBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaTaller/Reporte/Observacion/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Observacion'), 'BusetaTallerBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaTaller/Reporte/Observacion/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Lists all Observacion entities.
     *
     */
    public function indexAction(Request $request)
    {
        $filter = new DiagnosticoFilterModel();

        $form = $this->createForm(new DiagnosticoFilter(), $filter, array(
            'action' => $this->generateUrl('diagnostico'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Diagnostico')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Diagnostico')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );


        return $this->render('BusetaTallerBundle:Diagnostico:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Observacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Observacion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tareaadicional_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:Observacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Observacion entity.
    *
    * @param Observacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Observacion $entity)
    {
        $form = $this->createForm(new ObservacionType(), $entity, array(
            'action' => $this->generateUrl('tareaadicional_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Observacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Observacion();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:Observacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Observacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Observacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Observacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:Observacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Observacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Observacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Observacion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:Observacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Observacion entity.
    *
    * @param Observacion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Observacion $entity)
    {
        $form = $this->createForm(new ObservacionType(), $entity, array(
            'action' => $this->generateUrl('tareaadicional_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Observacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Observacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Observacion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tareaadicional_edit', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:Observacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Observacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaTallerBundle:Observacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Observacion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tareaadicional'));
    }

    /**
     * Creates a form to delete a Observacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tareaadicional_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Creates a form to create a Tarea Adicional entity.
     *
     * @param Linea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateReporteForm(Observacion $entity)
    {
        $form = $this->createForm(new ObservacionType(), $entity, array(
            'action' => $this->generateUrl('observacion_orden_trabajo_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    public function create_reporteAction(Request $request)
    {
        $entity = new Observacion();
        $form = $this->createCreateReporteForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }
}
