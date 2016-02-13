<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Direccion;
use Buseta\BodegaBundle\Form\Model\TerceroModel;
use Buseta\BodegaBundle\Form\Type\DireccionType;
use Buseta\BodegaBundle\Form\Filter\TerceroFilter;
use Buseta\BodegaBundle\Form\Model\TerceroFilterModel;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\BodegaBundle\Form\Type\TerceroType;
use Symfony\Component\HttpFoundation\Response;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
/**
 * Tercero controller.
 *
 * @Route("/tercero")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Bodegas", routeName="bodega_principal")
 */
class TerceroController extends Controller
{
    /**
     * @param $page
     * @param $cantResult
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/busqueda-avanzada/{page}/{cantResult}", name="tercero_ajax_busqueda_avanzada", defaults={"page": 0, "cantResult": 10})
     * @Method({"GET"})
     */
    public function busquedaAvanzadaAction($page, $cantResult)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $request = $this->getRequest();

        $orderBy = $request->query->get('orderBy');
        $filter  = $request->query->get('filter');

        $busqueda = $em->getRepository('BusetaBodegaBundle:Tercero')
            ->busquedaAvanzada($page, $cantResult, $filter, $orderBy);

        $paginacion = $busqueda['paginacion'];
        $results    = $busqueda['results'];

        return $this->render('BusetaBodegaBundle:Extras/table:busqueda-avanzada-terceros.html.twig', array(
            'terceros'   => $results,
            'page'       => $page,
            'cantResult' => $cantResult,
            'orderBy'    => $orderBy,
            'paginacion' => $paginacion,
        ));
    }

    /**
     * Lists all Tercero entities.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="tercero")
     * @Method("GET")
     * @Breadcrumb(title="Listado de Terceros", routeName="tercero")
     */
    public function indexAction(Request $request)
    {
        $filter = new TerceroFilterModel();

        $form = $this->createForm(new TerceroFilter(), $filter, array(
            'action' => $this->generateUrl('tercero'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Tercero')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Tercero')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:Tercero:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Tercero entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/create", name="tercero_create")
     * @Method("POST")
     * @Breadcrumb(title="Crear Nuevo Tercero", routeName="tercero_create")
     */
    public function createAction(Request $request)
    {
        $model = new TerceroModel();
        $form = $this->createCreateForm($model);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            $tercero = $model->getEntityData();

            try {
                $em->persist($tercero);
                $em->flush();

                $message = $this->get('translator')->trans('messages.create.success', array(), 'BusetaBodegaBundle');
                if($request->isXmlHttpRequest()) {
                    $model = new TerceroModel($tercero);
                    $form = $this->createEditForm($model);

                    $view = $this->renderView('BusetaBodegaBundle:Tercero:edit.html.twig', array(
                        'edit_form' => $form->createView(),
                        'entity' => $tercero,
                    ));

                    return new JsonResponse(array(
                        'message' => $message,
                        'view' => $view,
                    ), 201);
                }

                $this->get('session')->getFlashBag()->add('success', $message);

                return $this->redirect($this->generateUrl('tercero_show', array('id' => $tercero->getId())));
            } catch (\Exception $e) {
                $error = $this->get('translator')->trans('messages.create.error.%key%', array('key' => 'Tercero'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf('%s .%s', $error, $e->getMessage()));

                if ($request->isXmlHttpRequest()) {
                    $form->addError(new FormError($error));
                } else {
                    $this->get('session')->getFlashBag()->add('danger', $error);
                }
            }
        }

        $view = $this->renderView('BusetaBodegaBundle:Tercero:new.html.twig', array(
            'form' => $form->createView(),
        ));

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'view' => $view,
            ));
        }

        return new Response($view);
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
            'action' => $this->generateUrl('tercero_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Tercero entity.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/new", name="tercero_new")
     * @Method("GET")
     * @Breadcrumb(title="Crear Nuevo Tercero", routeName="tercero_new")
     */
    public function newAction()
    {
        $model = new TerceroModel();
        $form  = $this->createCreateForm($model);

        return $this->render('BusetaBodegaBundle:Tercero:new.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tercero entity.
     *
     * @Route("/{id}/show", name="tercero_show")
     * @Method("GET")
     * @Breadcrumb(title="Ver Datos de Tercero", routeName="tercero_show", routeParameters={"id"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Tercero')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tercero entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Tercero:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tercero entity.
     *
     * @param Tercero $tercero
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="tercero_edit")
     * @Method("GET")
     * @Breadcrumb(title="Modificar Tercero", routeName="tercero_edit", routeParameters={"id"})
     */
    public function editAction(Tercero $tercero)
    {
        $model = new TerceroModel($tercero);
        $editForm = $this->createEditForm($model);

        return $this->render('BusetaBodegaBundle:Tercero:edit.html.twig', array(
            'entity'      => $tercero,
            'edit_form'   => $editForm->createView(),
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
            'action' => $this->generateUrl('tercero_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Tercero entity.
     *
     * @Route("/{id}/update", name="tercero_update")
     * @Method({"PUT","POST"})
     * @Breadcrumb(title="Modificar Tercero", routeName="tercero_update", routeParameters={"id"})
     */
    public function updateAction(Request $request, Tercero $tercero)
    {
        $model = new TerceroModel($tercero);
        $editForm = $this->createEditForm($model);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            $tercero->setModelData($model);

            try {
                $em->persist($tercero);
                $em->flush();

                $message = $this->get('translator')->trans('messages.update.success', array(), 'BusetaBodegaBundle');
                if($request->isXmlHttpRequest()) {
                    $model = new TerceroModel($tercero);
                    $editForm = $this->createEditForm($model);

                    $view = $this->renderView('BusetaBodegaBundle:Tercero:edit.html.twig', array(
                        'edit_form' => $editForm->createView(),
                        'entity' => $tercero,
                    ));

                    return new JsonResponse(array(
                        'message' => $message,
                        'view' => $view,
                    ), 202);
                }

                $this->get('session')->getFlashBag()->add('success', $message);

                return $this->redirect($this->generateUrl('tercero_show', array('id' => $tercero->getId())));
            } catch (\Exception $e) {
                $error = $this->get('translator')->trans('messages.update.error.%key%', array('key' => 'Tercero'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf('%s .%s', $error, $e->getMessage()));

                if ($request->isXmlHttpRequest()) {
                    $editForm->addError(new FormError($error));
                } else {
                    $this->get('session')->getFlashBag()->add('danger', $error);
                }
            }
        }

        $view = $this->renderView('BusetaBodegaBundle:Tercero:edit.html.twig', array(
            'entity'      => $tercero,
            'edit_form'   => $editForm->createView(),
        ));

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse(array(
                'view' => $view,
            ));
        }

        return new Response($view);
    }

    /**
     * Deletes a Tercero entity.
     *
     * @Route("/{id}/delete", name="tercero_delete")
     * @Method({"DELETE", "POST"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BusetaBodegaBundle:Tercero')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tercero entity.');
            }

            try {
                $em->remove($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Ha sido eliminado satisfactoriamente.');
            } catch (\Exception $e) {
                $this->get('logger')->addCritical(
                    sprintf('Ha ocurrido un error eliminando un Tercero. Detalles: %s',
                    $e->getMessage()
                ));
            }
        }

        return $this->redirect($this->generateUrl('tercero'));
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
            ->setAction($this->generateUrl('tercero_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
