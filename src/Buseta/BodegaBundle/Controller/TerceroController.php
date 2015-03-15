<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Direccion;
use Buseta\BodegaBundle\Form\Model\TerceroModel;
use Buseta\BodegaBundle\Form\Type\DireccionType;
use Buseta\BodegaBundle\Form\Filter\TerceroFilter;
use Buseta\BodegaBundle\Form\Model\TerceroFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\BodegaBundle\Form\Type\TerceroType;

/**
 * Tercero controller.
 *
 */
class TerceroController extends Controller
{
    /**
     * Lists all Tercero entities.
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
            5
        );

        return $this->render('BusetaBodegaBundle:Tercero:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Tercero entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TerceroModel();
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($entity->getDireccionId() !== null && $entity->getDireccionId() !== '') {
                $direccion = $em->find('BusetaBodegaBundle:Direccion',$entity->getDireccionId());
            }

            $tercero = new Tercero();
            $tercero->setActivo($entity->getActivo());

            if (isset($direccion)) {
                $tercero->setDireccion($direccion);
            }

            $tercero->setAlias($entity->getAlias());
            $tercero->setApellidos($entity->getApellidos());
            $tercero->setCliente($entity->getCliente());
            $tercero->setCodigo($entity->getCodigo());
            $tercero->setInstitucion($entity->getDireccion());
            $tercero->setNombres($entity->getNombres());
            $tercero->setProveedor($entity->getProveedor());
            $tercero->setPersona($entity->getPersona());
            $em->persist($tercero);

            $em->flush();

            return $this->redirect($this->generateUrl('tercero_show', array('id' => $tercero->getId())));
        }

        $direccion = $this->createForm(new DireccionType());

        return $this->render('BusetaBodegaBundle:Tercero:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'direccion' => $direccion->createView(),
        ));
    }

    /**
    * Creates a form to create a Tercero entity.
    *
    * @param Tercero $entity The entity
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
     */
    public function newAction(Request $request)
    {
        //$tipo_contacto = $this->createForm(new MecanismoContactoType());

        //$entity->addMecanismoscontacto(new MecanismoContacto());

        $direccion = $this->createForm(new DireccionType());

        $model = new TerceroModel();
        $form  = $this->createCreateForm($model);

        return $this->render('BusetaBodegaBundle:Tercero:new.html.twig', array(
            'form'   => $form->createView(),
            //'tipo_contacto' => $tipo_contacto->createView(),
            'direccion' => $direccion->createView(),
        ));
    }

    /**
     * Finds and displays a Tercero entity.
     *
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
     */
    public function editAction(Tercero $tercero)
    {
        $model = new TerceroModel($tercero);
        $editForm = $this->createEditForm($model);
        $deleteForm = $this->createDeleteForm($tercero->getId());

        $direccionForm = $this->createForm(new DireccionType(), $tercero->getDireccion());

        return $this->render('BusetaBodegaBundle:Tercero:edit.html.twig', array(
            'entity'      => $tercero,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'direccion'   => $direccionForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Tercero entity.
    *
    * @param Tercero $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TerceroModel $entity)
    {
        $form = $this->createForm(new TerceroType(), $entity, array(
            'action' => $this->generateUrl('tercero_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Tercero entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $tercero = $em->getRepository('BusetaBodegaBundle:Tercero')->find($id);

        if (!$tercero) {
            throw $this->createNotFoundException('Unable to find Tercero entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $model = new TerceroModel($tercero);
        $editForm = $this->createEditForm($model);

        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            if ($model->getDireccionId() !== null && $model->getDireccionId() !== '') {
                $direccion = $em->find('BusetaBodegaBundle:Direccion', $model->getDireccionId());
            }

            $tercero->setActivo($model->getActivo());

            if (isset($direccion)) {
                $tercero->setDireccion($direccion);
            }

            $tercero->setAlias($model->getAlias());
            $tercero->setApellidos($model->getApellidos());
            $tercero->setCliente($model->getCliente());
            $tercero->setCodigo($model->getCodigo());
            $tercero->setInstitucion($model->getDireccion());
            $tercero->setNombres($model->getNombres());
            $tercero->setProveedor($model->getProveedor());
            $tercero->setPersona($model->getPersona());

            $em->persist($tercero);
            $em->flush();

            return $this->redirect($this->generateUrl('tercero_edit', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:Tercero:edit.html.twig', array(
            'entity'      => $tercero,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tercero entity.
     *
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
