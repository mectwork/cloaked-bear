<?php

namespace HatueyERP\TercerosBundle\Controller;

use HatueyERP\TercerosBundle\Entity\Persona;
use HatueyERP\TercerosBundle\Form\Filter\TerceroFilter;
use HatueyERP\TercerosBundle\Form\Model\TerceroFilterModel;
use HatueyERP\TercerosBundle\Form\Model\TerceroModel;
use HatueyERP\TercerosBundle\Form\Type\DireccionAjaxType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use HatueyERP\TercerosBundle\Entity\Tercero;
use HatueyERP\TercerosBundle\Form\Type\TerceroType;

/**
 * Tercero controller.
 *
 * @Route("/tercero")
 */
class TerceroController extends Controller
{

    /**
     * Lists all Tercero entities.
     *
     * @Route("/", name="terceros_tercero", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $filter = new TerceroFilterModel();

        $form = $this->createForm(new TerceroFilter(), $filter, array(
            'action' => $this->generateUrl('terceros_tercero'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('HatueyERPTercerosBundle:Tercero')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('HatueyERPTercerosBundle:Tercero')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('HatueyERPTercerosBundle:Tercero:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Tercero entity.
     *
     * @Route("/create", name="terceros_tercero_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $terceroModel = new TerceroModel();
        $form = $this->createCreateForm($terceroModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $entity = $terceroModel->getEntityData();

                $em->persist($entity);
                $em->flush();

                // Creando nuevamente el formulario con los datos actualizados de la entidad
                $form = $this->createEditForm(new TerceroModel($entity));
                $renderView = $this->renderView('@HatueyERPTerceros/Tercero/form_template.html.twig', array(
                    'form'   => $form->createView(),
                ));

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.create.success', array(), 'HatueyERPTercerosBundle')
                ), 201);
            } catch (\Exception $e) {
                $logger->addCritical(sprintf(
                    $trans->trans('', array(), 'HatueyERPTercerosBundle') . '. Detalles: %s',
                    $e->getMessage()
                ));

                return new JsonResponse(array(
                    'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Tercero'), 'HatueyERPTercerosBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@HatueyERPTerceros/Tercero/form_template.html.twig', array(
            'form'     => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
    * Creates a form to create a Tercero entity.
    *
    * @param TerceroModel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TerceroModel $entity)
    {
        $form = $this->createForm(new TerceroType(), $entity, array(
            'action' => $this->generateUrl('terceros_tercero_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Tercero entity.
     *
     * @Route("/new", name="terceros_tercero_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $form   = $this->createCreateForm(new TerceroModel());

        return $this->render('HatueyERPTercerosBundle:Tercero:new.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tercero entity.
     *
     * @Route("/{id}/show", name="terceros_tercero_show", methods={"GET"})
     */
    public function showAction(Tercero $tercero)
    {
//        $deleteForm = $this->createDeleteForm($tercero->getId());

        return $this->render('HatueyERPTercerosBundle:Tercero:show.html.twig', array(
            'entity'      => $tercero,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tercero entity.
     *
     * @Route("/{id}/edit", name="terceros_tercero_edit", methods={"GET"}, options={"expose":true})
     */
    public function editAction(Tercero $tercero)
    {
        $editForm = $this->createEditForm($tercero);
        $deleteForm = $this->createDeleteForm($tercero->getId());

        return $this->render('HatueyERPTercerosBundle:Tercero:edit.html.twig', array(
            'entity'        => $tercero,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Tercero entity.
    *
    * @param TerceroModel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TerceroModel $entity)
    {
        $form = $this->createForm(new TerceroType(), $entity, array(
            'action' => $this->generateUrl('terceros_tercero_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Tercero entity.
     *
     * @Route("/{id}/update", name="terceros_tercero_update", methods={"POST","PUT"}, options={"expose":true})
     */
    public function updateAction(Request $request, Tercero $tercero)
    {
        $terceroModel = new TerceroModel($tercero);
        $editForm = $this->createEditForm($terceroModel);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $tercero->setModelData($terceroModel);
                $em->flush();

                $renderView = $this->renderView('@HatueyERPTerceros/Tercero/form_template.html.twig', array(
                    'form'     => $editForm->createView(),
                ));

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.update.success', array(), 'HatueyERPTercerosBundle')
                ), 202);
            } catch (\Exception $e) {
                $logger->addCritical(sprintf(
                    $trans->trans('messages.update.success', array(), 'HatueyERPTercerosBundle'). '. Detalles: %s',
                    $e->getMessage()
                ));

                new JsonResponse(array(
                    'message' => $trans->trans('messages.update.error.%entidad%', array('entidad' => 'Tercero'), 'HatueyERPTercerosBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@HatueyERPTerceros/Tercero/form_template.html.twig', array(
            'form'     => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Deletes a Tercero entity.
     *
     * @Route("/{id}/delete", name="terceros_tercero_delete", methods={"DELETE","POST"}, options={"expose":true})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HatueyERPTercerosBundle:Tercero')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tercero entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('terceros_tercero'));
    }

    /**
     * Creates a form to delete a Tercero entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('terceros_tercero_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
