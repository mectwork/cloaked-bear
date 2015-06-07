<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Form\Model\ProveedorModel;
use Buseta\NomencladorBundle\Entity\FormaPago;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Buseta\BodegaBundle\Entity\Proveedor;
use Buseta\BodegaBundle\Form\Type\ProveedorType;

/**
 * Proveedor controller.
 *
 * @Route("/bodega/proveedor")
 */
class ProveedorController extends Controller
{
    /**
     * Lists all Proveedor entities.
     *
     * @Route("/", name="proveedor")
     *
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:Proveedor')->findAll();

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:Proveedor:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Proveedor entity.
     *
     * @Route("/", name="proveedor_create", options={"expose":true})
     *
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new ProveedorModel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $trans = $this->get('translator');
            $logger = $this->get('logger');

            try {
                $tercero = $entity->getTerceroData();
                $em->persist($tercero);

                $proveedor = $entity->getProveedorData();
                $proveedor->setTercero($tercero);

                $em->persist($proveedor);

                $em->flush();

                // Creando nuevamente el formulario con los datos actualizados de la entidad
                $form = $this->createEditForm(new ProveedorModel($proveedor));
                $renderView = $this->renderView('BusetaBodegaBundle:Proveedor:proveedor_model.html.twig', array(
                    'form' => $form->createView(),
                ));

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle'),
                ), 201);
            } catch (\Exception $e) {
                $logger->addCritical(sprintf(
                    $trans->trans('', array(), 'BusetaBodegaBundle').'. Detalles: %s',
                    $e->getMessage()
                ));

                return new JsonResponse(array(
                    'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Proveedor'), 'BusetaBodegaBundle'),
                ), 500);
            }
        }

        $renderView = $this->renderView('@BusetaBodega/Proveedor/proveedor_model.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a Proveedor entity.
     *
     * @param Proveedor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ProveedorModel $entity)
    {
        $form = $this->createForm(new ProveedorType(), $entity, array(
            'action' => $this->generateUrl('proveedor_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Proveedor entity.
     *
     * @Route("/new", name="proveedor_new")
     *
     * @Method("GET")
     */
    public function newAction()
    {
        $entity = new ProveedorModel();

        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:Proveedor:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Proveedor entity.
     *
     * @Route("/{id}", name="proveedor_show")
     *
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }

        $entity = new ProveedorModel($entity);

        return $this->render('BusetaBodegaBundle:Proveedor:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Proveedor entity.
     *
     * @Route("/{id}/edit", name="proveedor_edit")
     *
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('BusetaBodegaBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }

        $tercero = $entity->getTercero();
        $entity = new ProveedorModel($entity);
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Proveedor:edit.html.twig', array(
            'entity'      => $entity,
            'tercero'     => $tercero,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Proveedor entity.
     *
     * @param Proveedor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ProveedorModel $entity)
    {
        $form = $this->createForm(new ProveedorType(), $entity, array(
            'action' => $this->generateUrl('proveedor_update', array('id' => $entity->getProveedorId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Proveedor entity.
     *
     * @Route("/{id}", name="proveedor_update", options={"expose":true})
     *
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('BusetaBodegaBundle:Proveedor')->find($id);
        $marcasOld = new ArrayCollection();
        foreach ($entity->getMarcas() as $marca) {
            $marcasOld->add($marca);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }

        $model = new ProveedorModel($entity);
        $editForm = $this->createEditForm($model);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $trans  = $this->get('translator');

            $marcasNew = $model->getMarcas();
            foreach ($marcasNew as $marca) {
                if (null === $marca->getId()) {
                    $em->persist($marca);
                }
            }
            $em->flush();

            $tercero = $entity->getTercero();

            $entity->setModelData($model);
            $tercero->setModelData($model);

            $em->persist($tercero);
            $em->persist($entity);

            $em->flush();

            $model = new ProveedorModel($entity);
            $editForm = $this->createEditForm($model);
            $renderView = $this->renderView('BusetaBodegaBundle:Proveedor:proveedor_model.html.twig', array(
                'entity' => $entity,
                'form'   => $editForm->createView(),
            ));

            return new JsonResponse(array(
                'view' => $renderView,
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle'),
            ), 202);
        }

        $renderView = $this->renderView('BusetaBodegaBundle:Proveedor:proveedor_model.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }
    /**
     * Deletes a Proveedor entity.
     *
     * @Route("/{id}", name="proveedor_delete")
     *
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $entity = $em->getRepository('BusetaBodegaBundle:Tercero')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proveedor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('proveedor'));
    }

    /**
     * Creates a form to delete a Proveedor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proveedor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
