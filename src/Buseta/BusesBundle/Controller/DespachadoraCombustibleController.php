<?php

namespace Buseta\BusesBundle\Controller;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BusesBundle\Entity\DespachadoraCombustible;
use Buseta\BusesBundle\Form\Filter\DespachadoraCombustibleFilter;
use Buseta\BusesBundle\Form\Model\DespachadoraCombustibleFilterModel;
use Buseta\BusesBundle\Form\Type\DespachadoraCombustibleType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * DespachadoraCombustible controller.
 *
 * @Route("/despachadoraCombustible")
 */
class DespachadoraCombustibleController extends Controller
{
    /**
     * Lists all DespachadoraCombustible entities.
     *
     * @Route("/", name="despachadoraCombustible")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new DespachadoraCombustibleFilterModel();

        $form = $this->createForm(new DespachadoraCombustibleFilter(), $filter, array(
            'action' => $this->generateUrl('despachadoraCombustible'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBusesBundle:DespachadoraCombustible')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBusesBundle:DespachadoraCombustible')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaBusesBundle:DespachadoraCombustible:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new DespachadoraCombustible entity.
     *
     * @Route("/new", name="despachadoraCombustible_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $entity = new DespachadoraCombustible();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBusesBundle:DespachadoraCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DespachadoraCombustible entity.
     *
     * @param DespachadoraCombustible $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DespachadoraCombustible $entity)
    {
        $form = $this->createForm('buses_despachadora_combustible', $entity, array(
            'action' => $this->generateUrl('despachadoraCombustible_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a new DespachadoraCombustible entity.
     *
     * @Route("/create", name="despachadoraCombustible_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $entity = new DespachadoraCombustible();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $request = $this->get('request');
            $datos = $request->request->get('buses_despachadora_combustible');
            //Comparar la existencia de cantidadLibros disponibles para el nomenclador seleccionado

            $idNomencladorCombustible = $datos['combustible'];

            $nomencladorCombustible = $em->getRepository('BusetaBusesBundle:ConfiguracionCombustible')
                ->find($idNomencladorCombustible);

            $producto           = $em->getRepository('BusetaBodegaBundle:Producto')->find($nomencladorCombustible->getProducto()->getId());
            $bodega             = $em->getRepository('BusetaBodegaBundle:Bodega')->find($nomencladorCombustible->getBodega()->getId());
            $cantidadProducto   = $datos['cantidadLibros'];

            $fe = new FuncionesExtras();
            $cantidadDisponible = $fe->comprobarCantProductoAlmacen($producto, $bodega, $cantidadProducto, $em);

            //Comprobar la existencia del producto en la bodega seleccionada
            if ($cantidadDisponible == 'No existe') {
                //Volver al menu de de crear nuevo DespachadoraCombustible

                $form   = $this->createCreateForm($entity);

                $form->addError(new FormError("El producto '".$producto->getNombre()."' no existe en la bodega del combustible seleccionado"));

                return $this->render('BusetaBusesBundle:DespachadoraCombustible:new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ));
            }
            //Si no existe la cantidad solicitada en el almacen del producto seleccionado
            elseif ($cantidadDisponible < 0) {
                //Volver al menu de de crear nuevo DespachadoraCombustible
                $form   = $this->createCreateForm($entity);

                $form->addError(new FormError("No existe en la bodega '".$bodega->getNombre()."' la cantidad de productos solicitados para el producto: ".$producto->getNombre()));

                return $this->render('BusetaBusesBundle:DespachadoraCombustible:new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ));
            }
            //Si sí existe la cantidad del producto en la bodega seleccionada
            else {
                //Actualizar Bitácora - AlmacenOrigen
                $bitacora = new BitacoraAlmacen();
                $bitacora->setProducto($producto);
                $bitacora->setFechaMovimiento(new \DateTime());
                $bitacora->setAlmacen($bodega);
                $bitacora->setCantMovida($datos['cantidadLibros']);
                $bitacora->setTipoMovimiento('M-');
                $em->persist($bitacora);
                $em->flush();

                $em->persist($entity);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('despachadoraCombustible_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBusesBundle:DespachadoraCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DespachadoraCombustible entity.
     *
     * @Route("/{id}/show", name="despachadoraCombustible_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBusesBundle:DespachadoraCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DespachadoraCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBusesBundle:DespachadoraCombustible:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DespachadoraCombustible entity.
     *
     * @Route("/{id}/delete", name="despachadoraCombustible_delete", options={"expose": true})
     * @Method({"DELETE", "GET", "POST"})
     */
    public function deleteAction(DespachadoraCombustible $despachadoraCombustible, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($despachadoraCombustible->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($despachadoraCombustible);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaBusesBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'DespachadoraCombustible'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBuses/DespachadoraCombustible/delete_modal.html.twig', array(
            'entity' => $despachadoraCombustible,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('despachadoraCombustible'));
    }

    /**
     * Creates a form to delete a DespachadoraCombustible entity by id.
     *
     * @param mixed $id The entity id
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('despachadoraCombustible_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Displays a form to edit an existing Tercero entity.
     *
     * @param DespachadoraCombustible $despachadoraCombustible
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="despachadoraCombustible_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBusesBundle:DespachadoraCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DespachadoraCombustible entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBusesBundle:DespachadoraCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param DespachadoraCombustible $despachadoraCombustible The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(DespachadoraCombustible $entity)
    {
        $form = $this->createForm(new DespachadoraCombustibleType(), $entity, array(
            'action' => $this->generateUrl('despachadoraCombustible_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing DespachadoraCombustible entity.
     *
     * @Route("/{id}/update", name="despachadoraCombustible_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBusesBundle:DespachadoraCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DespachadoraCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('despachadoraCombustible_show', array('id' => $id)));
        }

        return $this->render('BusetaBusesBundle:DespachadoraCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
