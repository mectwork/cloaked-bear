<?php

namespace Buseta\CombustibleBundle\Controller;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\CombustibleBundle\Entity\ServicioCombustible;
use Buseta\CombustibleBundle\Form\Filter\ServicioCombustibleFilter;
use Buseta\CombustibleBundle\Form\Model\ServicioCombustibleFilterModel;
use Buseta\CombustibleBundle\Form\Model\ServicioCombustibleModel;
use Buseta\CombustibleBundle\Form\Type\ServicioCombustibleType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * ServicioCombustible controller.
 *
 * @Route("/servicioCombustible")
 */
class ServicioCombustibleController extends Controller
{
    /**
     * Lists all ServicioCombustible entities.
     *
     * @Route("/", name="servicioCombustible")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new ServicioCombustibleFilterModel();

        $form = $this->createForm(new ServicioCombustibleFilter(), $filter, array(
            'action' => $this->generateUrl('servicioCombustible'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaCombustibleBundle:ServicioCombustible')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaCombustibleBundle:ServicioCombustible')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaCombustibleBundle:ServicioCombustible:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new ServicioCombustible entity.
     *
     * @Route("/new", name="servicioCombustible_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $entity = new ServicioCombustibleModel();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaCombustibleBundle:ServicioCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ServicioCombustible entity.
     *
     * @param ServicioCombustible $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ServicioCombustibleModel $entity)
    {
        $form = $this->createForm('combustible_servicio_combustible', $entity, array(
            'action' => $this->generateUrl('servicioCombustible_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a new ServicioCombustible entity.
     *
     * @Route("/create", name="servicioCombustible_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $entityModel = new ServicioCombustibleModel();
        $form = $this->createCreateForm($entityModel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            //Comparar la existencia de cantidadLibros disponibles para el nomenclador seleccionado
            $producto           = $entityModel->getCombustible()->getProducto();
            $bodega             = $entityModel->getCombustible()->getBodega();
            $cantidadProducto   = $entityModel->getCantidadLibros();

            $fe = new FuncionesExtras();
            $cantidadDisponible = $fe->comprobarCantProductoAlmacen($producto, $bodega, $cantidadProducto, $em);

            //Comprobar la existencia del producto en la bodega seleccionada
            if ($cantidadDisponible == 'No existe') {
                //Volver al menu de de crear nuevo ServicioCombustible

                $form   = $this->createCreateForm($entityModel);

                $form->addError(new FormError("El producto '".$producto->getNombre()."' no existe en la bodega del combustible seleccionado"));

                return $this->render('BusetaCombustibleBundle:ServicioCombustible:new.html.twig', array(
                    'entity' => $entityModel,
                    'form'   => $form->createView(),
                ));
            }

            //Si sí existe la cantidad del producto en la bodega seleccionada
            else {

                try
                {
                    //Actualizar Bitácora - AlmacenOrigen
                    $bitacora = new BitacoraAlmacen();
                    $bitacora->setProducto($producto);
                    $bitacora->setFechaMovimiento(new \DateTime());
                    $bitacora->setAlmacen($bodega);
                    $bitacora->setCantMovida($entityModel->getCantidadLibros());
                    $bitacora->setTipoMovimiento('M-');
                    $em->persist($bitacora);

                    $servicioCombustible = $entityModel->getEntityData();

                    $em->persist($servicioCombustible);
                    $em->flush();

                    return $this->redirect($this->generateUrl('servicioCombustible_show', array('id' => $servicioCombustible->getId())));

                }
                catch (\Exception $e) {
                    $logger->addCritical(sprintf(
                        $trans->trans('', array(), 'BusetaCombustibleBundle') . '. Detalles: %s',
                        $e->getMessage()
                    ));

                    return new JsonResponse(array(
                        'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Servicio de Combustible'), 'BusetaCombustibleBundle')
                    ), 500);
                }

            }

            //return $this->redirect($this->generateUrl('servicioCombustible_show', array('id' => $servicioCombustible->getId())));
        }

        return $this->render('BusetaCombustibleBundle:ServicioCombustible:new.html.twig', array(
            'entity' => $entityModel,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ServicioCombustible entity.
     *
     * @Route("/{id}/show", name="servicioCombustible_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ServicioCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaCombustibleBundle:ServicioCombustible:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ServicioCombustible entity.
     *
     * @Route("/{id}/delete", name="servicioCombustible_delete", options={"expose": true})
     * @Method({"DELETE", "GET", "POST"})
     */
    public function deleteAction(ServicioCombustible $servicioCombustible, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($servicioCombustible->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($servicioCombustible);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'ServicioCombustible'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBuses/ServicioCombustible/delete_modal.html.twig', array(
            'entity' => $servicioCombustible,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('servicioCombustible'));
    }

    /**
     * Creates a form to delete a ServicioCombustible entity by id.
     *
     * @param mixed $id The entity id
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicioCombustible_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Displays a form to edit an existing Tercero entity.
     *
     * @param ServicioCombustible $servicioCombustible
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="servicioCombustible_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ServicioCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioCombustible entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaCombustibleBundle:ServicioCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param ServicioCombustible $servicioCombustible The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ServicioCombustible $entity)
    {
        $form = $this->createForm(new ServicioCombustibleType(), $entity, array(
            'action' => $this->generateUrl('servicioCombustible_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing ServicioCombustible entity.
     *
     * @Route("/{id}/update", name="servicioCombustible_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ServicioCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('servicioCombustible_show', array('id' => $id)));
        }

        return $this->render('BusetaCombustibleBundle:ServicioCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
