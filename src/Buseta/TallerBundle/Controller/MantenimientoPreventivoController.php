<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\MantenimientoPreventivo;
use Buseta\TallerBundle\Form\Filter\MantenimientoPreventivoFilter;
use Buseta\TallerBundle\Form\Model\MantenimientoPreventivoFilterModel;
use Buseta\TallerBundle\Form\Type\MantenimientoPreventivoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
/**
 * MantenimientoPreventivo controller.
 * @Route("/mpreventivo")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Taller", routeName="taller_principal")
 */
class MantenimientoPreventivoController extends Controller
{
    /**
     * Lists all MantenimientoPreventivo entities.
     *
     * @Route("/", name="mantenimientopreventivo", methods={"GET"})
     * @Breadcrumb(title="Mantenimientos Preventivos", routeName="mantenimientopreventivo")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $filter_param = new MantenimientoPreventivoFilterModel();

        $form = $this->createForm(new MantenimientoPreventivoFilter(), $filter_param, array(
            'action' => $this->generateUrl('mantenimientopreventivo'),
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entities = $em->getRepository('BusetaTallerBundle:MantenimientoPreventivo')->filter($filter_param);
        } else {
            $entities = $em->getRepository('BusetaTallerBundle:MantenimientoPreventivo')->findAll();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:index.html.twig', array(
            'entities' => $entities,
            'filter_form' => $form->createView(),
        ));
    }
    /**
     * Creates a new MantenimientoPreventivo entity.
     *
     * @Route("/create", name="mantenimientopreventivo_create", methods={"POST"})
     * @Breadcrumb(title="Crear Nuevo Mantenimiento Preventivo", routeName="mantenimientopreventivo_create")
     */
    public function createAction(Request $request)
    {
        $entity = new MantenimientoPreventivo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mantenimientopreventivo_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MantenimientoPreventivo entity.
     *
     * @param MantenimientoPreventivo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MantenimientoPreventivo $entity)
    {
        $form = $this->createForm(new MantenimientoPreventivoType(), $entity, array(
            'action' => $this->generateUrl('mantenimientopreventivo_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new MantenimientoPreventivo entity.
     *
     * @Route("/new", name="mantenimientopreventivo_new", methods={"GET"})
     * @Breadcrumb(title="Crear Nuevo Mantenimiento Preventivo", routeName="mantenimientopreventivo_new")
     */
    public function newAction()
    {
        $entity = new MantenimientoPreventivo();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MantenimientoPreventivo entity.
     *
     * @Route("/{id}/show", name="mantenimientopreventivo_show", methods={"GET"})
     * @Breadcrumb(title="Ver Datos de Mantenimiento Preventivo ", routeName="mantenimientopreventivo_show", routeParameters={"id"})
     */
    public function showAction(MantenimientoPreventivo $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MantenimientoPreventivo entity.
     *
     * @Route("/{id}/edit", name="mantenimientopreventivo_edit", methods={"GET"})
     * @Breadcrumb(title="Modificar Mantenimiento Preventivo", routeName="mantenimientopreventivo_edit", routeParameters={"id"})
     */
    public function editAction(MantenimientoPreventivo $entity)
    {
        $editForm = $this->createEditForm($entity);

        return $this->render('BusetaTallerBundle:MantenimientoPreventivo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a MantenimientoPreventivo entity.
     *
     * @param MantenimientoPreventivo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(MantenimientoPreventivo $entity)
    {
        $form = $this->createForm(new MantenimientoPreventivoType(), $entity, array(
            'action' => $this->generateUrl('mantenimientopreventivo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing MantenimientoPreventivo entity.
     *
     * @Route("/{id}/update", name="mantenimientopreventivo_update", methods={"PUT","POST"})
     * @Breadcrumb(title="Modificar Mantenimiento Preventivo", routeName="mantenimientopreventivo_update", routeParameters={"id"})
     */
    public function updateAction(Request $request, MantenimientoPreventivo $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mantenimientopreventivo_show', array('id' => $entity->getId())));
        }

        return $this->render('', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MantenimientoPreventivo entity.
     *
     * @Route("/{id}/delete", name="mantenimientopreventivo_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, MantenimientoPreventivo $entity)
    {
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

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

        return $this->redirect($this->generateUrl('mantenimientopreventivo'));
    }

    /**
     * Creates a form to delete a MantenimientoPreventivo entity by id.
     *
     * @param mixed $entity The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MantenimientoPreventivo $entity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mantenimientopreventivo_delete', array('id' => $entity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Selecciona los Subgrupos asociados al Grupo seleccionado.
     *
     * @param Request $request
     * @Route("/select_subgrupo_grupo", name="ajax_select_subgrupo_grupo", methods={"GET"})
     */
    public function selectSubgroupBelongGroupAction(Request $request)
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
     * Selecciona las Tareas asociadas al Subgrupo seleccionado.
     *
     * @param Request $request
     * @Route("/select_tarea_subgrupo", name="ajax_select_tarea_subgrupo", methods={"GET"})
     */
    public function selectTareaBelongSubgroupAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $subgrupo_id = $request->query->get('subgrupo_id');
        $tareas = $em->getRepository('BusetaTallerBundle:TareaMantenimiento')->findBy(array(
            'subgrupo' => $subgrupo_id,
        ));

        $json = array();
        foreach ($tareas as $tarea) {
            $json[] = array(
                'id' => $tarea->getId(),
                'valor' => $tarea->getValor()->getValor(),
            );
        }

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Selecciona las Garantias asociadas a la Tarea seleccionada.
     *
     * @param Request $request
     * @Route("/select_garantia_tarea", name="ajax_select_garantia_tarea", methods={"GET"})
     */
    public function selectGarantiaBelongTareaAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $tarea_id = $request->query->get('tarea_id');

        if (!is_numeric($tarea_id)) {
            return new \Symfony\Component\HttpFoundation\Response(json_encode(array()), 200);
        }

        $tarea = $em->getRepository('BusetaTallerBundle:TareaMantenimiento')->find($tarea_id);

        $garantia = $tarea->getGarantia()->getDias();

        return new \Symfony\Component\HttpFoundation\Response(json_encode(array('dias' => $garantia)), 200);
    }

    /**
     * Modifica los campos 'kilometraje' y 'horas' del MantenimientoPreventivo asociados a la Tarea seleccionada.
     *
     * @param Request $request
     * @Route("/select_mpreventivo_tarea", name="ajax_select_mpreventivo_tarea", methods={"GET"})
     */
    public function selectMPreventivoBelongSubgroupAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $tarea_id = $request->query->get('tarea_id');
        $tarea = $em->getRepository('BusetaNomencladorBundle:Tarea')->findOneBy(array(
            'id' => $tarea_id,
        ));

        $json = array();

        $json[] = array(
            'kilometros' => $tarea->getKilometros(),
            'horas' => $tarea->getHoras(),
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }
}
