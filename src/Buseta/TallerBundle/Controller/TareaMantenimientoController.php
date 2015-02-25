<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\NomencladorBundle\Entity\Tarea;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\TallerBundle\Entity\TareaMantenimiento;
use Buseta\TallerBundle\Form\Type\TareaMantenimientoType;

/**
 * TareaMantenimiento controller.
 *
 */
class TareaMantenimientoController extends Controller
{

    /**
     * Updated automatically select Subgrupos when change select Grupos
     *
     */
    public function select_grupo_subgrupoAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);

        if (!$request->isXmlHttpRequest())
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);

        $em = $this->get('doctrine.orm.entity_manager');
        $grupo_id = $request->query->get('grupo_id');
        $subgrupos = $em->getRepository('BusetaNomencladorBundle:Subgrupo')->findBy(array(
            'grupo' => $grupo_id
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
     * Updated automatically select Productos when change select Subgrupos
     *
     */
    public function select_subgrupo_productoAction(Request $request) {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);

        if (!$request->isXmlHttpRequest())
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);

        $em = $this->getDoctrine()->getManager();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findBy(array(
            'subgrupos' => $request->query->get('subgrupo_id')
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
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaNomencladorBundle:Tarea')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaTallerBundle:TareaMantenimiento:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TareaMantenimiento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Tarea();
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
    private function createCreateForm(Tarea $entity)
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
     *
     */
    public function newAction()
    {
        $entity = new Tarea();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:TareaMantenimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TareaMantenimiento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaNomencladorBundle:Tarea')->find($id);

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
     *
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('BusetaNomencladorBundle:Tarea')->find($id);

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
    private function createEditForm(Tarea $entity)
    {
        $form = $this->createForm(new TareaMantenimientoType(), $entity, array(
            'action' => $this->generateUrl('tareamantenimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TareaMantenimiento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaNomencladorBundle:Tarea')->find($id);

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
     * Deletes a TareaMantenimiento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaNomencladorBundle:Tarea')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TareaMantenimiento entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Ha sido eliminado satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('logger')->addCritical(
                    sprintf('Ha ocurrido un error eliminando una tarea de mantenimiento. Detalles: %s',
                        $e->getMessage()
                    ));
            }
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
