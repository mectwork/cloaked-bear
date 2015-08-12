<?php

namespace Buseta\CombustibleBundle\Controller;

use Buseta\CombustibleBundle\Entity\ListaNegraCombustible;
use Buseta\CombustibleBundle\Form\Filter\ListaNegraCombustibleFilter;
use Buseta\CombustibleBundle\Form\Model\ListaNegraCombustibleFilterModel;
use Buseta\CombustibleBundle\Form\Type\ListaNegraCombustibleType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * ListaNegraCombustible controller.
 *
 * @Route("/listaNegraCombustible")
 */
class ListaNegraCombustibleController extends Controller
{
    /**
     * Lists all ListaNegraCombustible entities.
     *
     * @Route("/", name="listaNegraCombustible")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new ListaNegraCombustibleFilterModel();

        $form = $this->createForm(new ListaNegraCombustibleFilter(), $filter, array(
            'action' => $this->generateUrl('listaNegraCombustible'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaCombustibleBundle:ListaNegraCombustible')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaCombustibleBundle:ListaNegraCombustible')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaCombustibleBundle:ListaNegraCombustible:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new ListaNegraCombustible entity.
     *
     * @Route("/new", name="listaNegraCombustible_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $entity = new ListaNegraCombustible();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaCombustibleBundle:ListaNegraCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ListaNegraCombustible entity.
     *
     * @param ListaNegraCombustible $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ListaNegraCombustible $entity)
    {
        $form = $this->createForm('combustible_lista_negra_combustible', $entity, array(
            'action' => $this->generateUrl('listaNegraCombustible_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a new ListaNegraCombustible entity.
     *
     * @Route("/create", name="listaNegraCombustible_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $entity = new ListaNegraCombustible();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('listaNegraCombustible_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaCombustibleBundle:ListaNegraCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ListaNegraCombustible entity.
     *
     * @Route("/{id}/show", name="listaNegraCombustible_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ListaNegraCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListaNegraCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaCombustibleBundle:ListaNegraCombustible:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ListaNegraCombustible entity.
     *
     * @Route("/{id}/delete", name="listaNegraCombustible_delete", options={"expose": true})
     * @Method({"DELETE", "GET", "POST"})
     */
    public function deleteAction(ListaNegraCombustible $listaNegraCombustible, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($listaNegraCombustible->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($listaNegraCombustible);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaCombustibleBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'ListaNegraCombustible'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaCombustible/ListaNegraCombustible/delete_modal.html.twig', array(
            'entity' => $listaNegraCombustible,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('listaNegraCombustible'));
    }

    /**
     * Creates a form to delete a ListaNegraCombustible entity by id.
     *
     * @param mixed $id The entity id
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('listaNegraCombustible_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Displays a form to edit an existing Tercero entity.
     *
     * @param ListaNegraCombustible $listaNegraCombustible
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="listaNegraCombustible_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ListaNegraCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListaNegraCombustible entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaCombustibleBundle:ListaNegraCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param ListaNegraCombustible $listaNegraCombustible The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ListaNegraCombustible $entity)
    {
        $form = $this->createForm(new ListaNegraCombustibleType(), $entity, array(
            'action' => $this->generateUrl('listaNegraCombustible_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing ListaNegraCombustible entity.
     *
     * @Route("/{id}/update", name="listaNegraCombustible_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ListaNegraCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListaNegraCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('listaNegraCombustible_show', array('id' => $id)));
        }

        return $this->render('BusetaCombustibleBundle:ListaNegraCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
