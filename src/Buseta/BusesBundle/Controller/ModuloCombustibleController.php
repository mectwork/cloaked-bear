<?php

namespace Buseta\BusesBundle\Controller;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BusesBundle\Entity\ModuloCombustible;
use Buseta\BusesBundle\Form\Filter\ModuloCombustibleFilter;
use Buseta\BusesBundle\Form\Model\ModuloCombustibleFilterModel;
use Buseta\BusesBundle\Form\Type\ModuloCombustibleType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * ModuloCombustible controller.
 *
 * @Route("/moduloCombustible")
 */
class ModuloCombustibleController extends Controller
{
    /**
     * Lists all ModuloCombustible entities.
     *
     * @Route("/", name="moduloCombustible")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new ModuloCombustibleFilterModel();

        $form = $this->createForm(new ModuloCombustibleFilter(), $filter, array(
            'action' => $this->generateUrl('moduloCombustible'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBusesBundle:ModuloCombustible')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBusesBundle:ModuloCombustible')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaBusesBundle:ModuloCombustible:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new ModuloCombustible entity.
     *
     * @Route("/new", name="moduloCombustible_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $entity = new ModuloCombustible();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBusesBundle:ModuloCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ModuloCombustible entity.
     *
     * @param ModuloCombustible $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ModuloCombustible $entity)
    {
        $form = $this->createForm('buses_modulo_combustible', $entity, array(
            'action' => $this->generateUrl('moduloCombustible_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a new ModuloCombustible entity.
     *
     * @Route("/create", name="moduloCombustible_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $entity = new ModuloCombustible();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $request = $this->get('request');
            $datos = $request->request->get('buses_modulo_combustible');
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
                //Volver al menu de de crear nuevo ModuloCombustible

                $form   = $this->createCreateForm($entity);

                $form->addError(new FormError("El producto '".$producto->getNombre()."' no existe en la bodega del combustible seleccionado"));

                return $this->render('BusetaBusesBundle:ModuloCombustible:new.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ));
            }
            //Si no existe la cantidad solicitada en el almacen del producto seleccionado
            elseif ($cantidadDisponible < 0) {
                //Volver al menu de de crear nuevo ModuloCombustible
                $form   = $this->createCreateForm($entity);

                $form->addError(new FormError("No existe en la bodega '".$bodega->getNombre()."' la cantidad de productos solicitados para el producto: ".$producto->getNombre()));

                return $this->render('BusetaBusesBundle:ModuloCombustible:new.html.twig', array(
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

            return $this->redirect($this->generateUrl('moduloCombustible_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBusesBundle:ModuloCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ModuloCombustible entity.
     *
     * @Route("/{id}/show", name="moduloCombustible_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBusesBundle:ModuloCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuloCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBusesBundle:ModuloCombustible:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ModuloCombustible entity.
     *
     * @Route("/{id}/delete", name="moduloCombustible_delete", options={"expose": true})
     * @Method({"DELETE", "GET", "POST"})
     */
    public function deleteAction(ModuloCombustible $moduloCombustible, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($moduloCombustible->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($moduloCombustible);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'ModuloCombustible'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBuses/ModuloCombustible/delete_modal.html.twig', array(
            'entity' => $moduloCombustible,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('moduloCombustible'));
    }

    /**
     * Creates a form to delete a ModuloCombustible entity by id.
     *
     * @param mixed $id The entity id
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('moduloCombustible_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Displays a form to edit an existing Tercero entity.
     *
     * @param ModuloCombustible $moduloCombustible
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="moduloCombustible_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBusesBundle:ModuloCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuloCombustible entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBusesBundle:ModuloCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param ModuloCombustible $moduloCombustible The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ModuloCombustible $entity)
    {
        $form = $this->createForm(new ModuloCombustibleType(), $entity, array(
            'action' => $this->generateUrl('moduloCombustible_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing ModuloCombustible entity.
     *
     * @Route("/{id}/update", name="moduloCombustible_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBusesBundle:ModuloCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ModuloCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('moduloCombustible_show', array('id' => $id)));
        }

        return $this->render('BusetaBusesBundle:ModuloCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
