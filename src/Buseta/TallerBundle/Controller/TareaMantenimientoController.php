<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Form\Filter\TareaMantenimientoFilter;
use Buseta\TallerBundle\Form\Model\TareaMantenimientoFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\TallerBundle\Entity\TareaMantenimiento;
use Buseta\TallerBundle\Form\Type\TareaMantenimientoType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * NecesidadMaterial controller.
 *
 * @Route("/tareamantenimiento")
 */
class TareaMantenimientoController extends Controller
{
    /**
     * Updated automatically select Subgrupos when change select Grupos.
     */
    public function select_grupo_subgrupoAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $grupo_id = $request->query->get('grupo_id');
        $subgrupos = $em->getRepository('BusetaNomencladorBundle:Subgrupo')->findBy(array(
            'grupo' => $grupo_id,
        ));

        $json = array();
        foreach ($subgrupos as $subgrupo) {
            $json[] = array(
                'id' => $subgrupo->getId(),
                'valor' => $subgrupo->getValor(),
            );
        }

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Updated automatically select Productos when change select Subgrupos.
     */
    public function select_subgrupo_productoAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findBy(array(
            'subgrupos' => $request->query->get('subgrupo_id'),
        ));

        $json = array();
        foreach ($productos as $producto) {
            $json[] = array(
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
            );
        }

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Lists all TareaMantenimiento entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new TareaMantenimientoFilterModel();

        $form = $this->createForm(new TareaMantenimientoFilter(), $filter, array(
            'action' => $this->generateUrl('tareamantenimiento'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:TareaMantenimiento')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:TareaMantenimiento')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaTallerBundle:TareaMantenimiento:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new TareaMantenimiento entity.
     */
    public function createAction(Request $request)
    {
        $entity = new TareaMantenimiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tareamantenimiento_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:TareaMantenimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TareaMantenimiento entity.
     *
     * @param TareaMantenimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TareaMantenimiento $entity)
    {
        $form = $this->createForm(new TareaMantenimientoType(), $entity, array(
            'action' => $this->generateUrl('tareamantenimiento_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TareaMantenimiento entity.
     */
    public function newAction()
    {
        $entity = new TareaMantenimiento();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:TareaMantenimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TareaMantenimiento entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaMantenimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaMantenimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:TareaMantenimiento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing TareaMantenimiento entity.
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('BusetaTallerBundle:TareaMantenimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaMantenimiento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:TareaMantenimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a TareaMantenimiento entity.
     *
     * @param TareaMantenimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TareaMantenimiento $entity)
    {
        $form = $this->createForm(new TareaMantenimientoType(), $entity, array(
            'action' => $this->generateUrl('tareamantenimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing TareaMantenimiento entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:TareaMantenimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TareaMantenimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tareamantenimiento_show', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:TareaMantenimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a NecesidadMaterial entity.
     *
     * @Route("/{id}/delete", name="tareamantenimiento_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(TareaMantenimiento $tareamantenimiento, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($tareamantenimiento->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($tareamantenimiento);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Tarea de Mantenimiento'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaTaller/TareaMantenimiento/delete_modal.html.twig', array(
            'entity' => $tareamantenimiento,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('tareamantenimiento'));
    }

    /**
     * Creates a form to delete a TareaMantenimiento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tareamantenimiento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
