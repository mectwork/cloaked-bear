<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\Diagnostico;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\TallerBundle\Entity\ObservacionDiagnostico;
use Buseta\TallerBundle\Form\Type\ObservacionDiagnosticoType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ObservacionDiagnosticoController
 * @package Buseta\TallerBundle\Controller
 *
 * @Route("/observaciondiagnostico")
 */
class ObservacionDiagnosticoController extends Controller
{
    /**
     * @param Diagnostico $diagnostico
     * @return Response
     *
     * @Route("/list/{diagnostico}", name="diagnosticos_observacion_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("diagnostico", options={"mapping":{"diagnostico":"id"}})
     */
    public function listAction(Diagnostico $diagnostico, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaTallerBundle:ObservacionDiagnostico')
            ->findAllByDiagnosticoId($diagnostico->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaTaller/Diagnostico/ObservacionDiagnostico/list_template.html.twig', array(
            'entities' => $entities,
            'diagnostico' => $diagnostico,
        ));
    }

    public function newModalObservacionDiagnosticoAction(Request $request)
    {
        $form = $this->createForm(new ObservacionDiagnosticoType(), null, array(
            'method' => 'POST',
            'action' => $this->generateUrl('observacion_new_modal')
        ));

        return $this->render('@BusetaTaller/Diagnostico/modal/modal_observacion.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param ObservacionDiagnostico $observacion
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/delete", name="diagnosticos_observacion_delete", methods={"GET", "POST", "DELETE"}, options={"expose":true})
     */
    public function deleteAction(ObservacionDiagnostico $observacion, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($observacion->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');
                if($observacion->getDiagnostico() && $observacion->getDiagnostico()->getOrdenTrabajo()) {
                    if($request->isXmlHttpRequest()) {
                        return new JsonResponse(array(
                            'message' => 'No se puede eliminar una observación de diagnóstico asociada a una orden de trabajo',
                        ), 500);
                    }
                }
                $em->remove($observacion);
                $em->flush();

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle'),
                    ), 202);
                }
                // faltaría forma tradicional
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'ObservacionDiagnostico'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaTaller/Reporte/Observacion/modal_delete.html.twig', array(
            'entity' => $observacion,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return new Response($renderView);
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/{diagnostico}", name="diagnosticos_observacion_new_modal", methods={"GET","POST"}, options={"expose":true})
     * @ParamConverter("diagnostico", options={"mapping":{"diagnostico":"id"}})
     */
    public function newModalAction(Diagnostico $diagnostico, Request $request)
    {
        $trans = $this->get('translator');
        $handler = $this->get('buseta_diagnostico.observacion.handler');
        $handler->bindData($diagnostico);

        $handler->setRequest($request);
        if($handler->handle()) {
            $renderView = $this->renderView('@BusetaTaller/Diagnostico/ObservacionDiagnostico/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaTallerBundle')
            ), 201);
        }

        if($handler->getError()) {
            $renderView = $this->renderView('@BusetaTaller/Diagnostico/ObservacionDiagnostico/modal_form.html.twig', array(
                'form' => $handler->getForm()->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.error.%key%', array('key' => 'ObservacionDiagnostico'), 'BusetaTallerBundle')
            ), 500);
        }

        $renderView = $this->renderView('@BusetaTaller/Diagnostico/ObservacionDiagnostico/modal_form.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Lists all ObservacionDiagnostico entities.
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
     * Creates a new ObservacionDiagnostico entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ObservacionDiagnostico();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tareaadicional_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:ObservacionDiagnostico:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ObservacionDiagnostico entity.
    *
    * @param ObservacionDiagnostico $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ObservacionDiagnostico $entity)
    {
        $form = $this->createForm(new ObservacionDiagnosticoType(), $entity, array(
            'action' => $this->generateUrl('tareaadicional_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ObservacionDiagnostico entity.
     *
     */
    public function newAction()
    {
        $entity = new ObservacionDiagnostico();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:ObservacionDiagnostico:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ObservacionDiagnostico entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:ObservacionDiagnostico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ObservacionDiagnostico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:ObservacionDiagnostico:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing ObservacionDiagnostico entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:ObservacionDiagnostico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ObservacionDiagnostico entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:ObservacionDiagnostico:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ObservacionDiagnostico entity.
    *
    * @param ObservacionDiagnostico $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ObservacionDiagnostico $entity)
    {
        $form = $this->createForm(new ObservacionDiagnosticoType(), $entity, array(
            'action' => $this->generateUrl('tareaadicional_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing ObservacionDiagnostico entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:ObservacionDiagnostico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ObservacionDiagnostico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tareaadicional_edit', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:ObservacionDiagnostico:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a ObservacionDiagnostico entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('observaciondiagnostico_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
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
    private function createCreateDiagnosticoForm(ObservacionDiagnostico $entity)
    {
        $form = $this->createForm(new ObservacionDiagnosticoType(), $entity, array(
            'action' => $this->generateUrl('observacion_orden_trabajo_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    public function create_diagnosticoAction(Request $request)
    {
        $entity = new ObservacionDiagnostico();
        $form = $this->createCreateDiagnosticoForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }
}
