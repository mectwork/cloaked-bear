<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Movimiento;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Form\Filter\MovimientosProductosFilter;
use Buseta\BodegaBundle\Form\Model\MovimientosProductosFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Form\Type\MovimientosProductosType;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Entity\SalidaBodegaProducto;
use Buseta\BodegaBundle\Form\Type\SalidaBodegaProductoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class SalidaBodegaProductoController
 * @package Buseta\BodegaBundle\Controller
 *
 * @Route("/salidabodega_producto")
 */
class SalidaBodegaProductoController extends Controller
{
    /**
     * @param MovimientosProductos $salidabodega_producto
     * @return Response
     *
     * @Route("/list/{salidabodega_producto}", name="salidabodega_productos_list", methods={"GET"}, options={"expose":true})
     * @ParamConverter("salidabodega_producto", options={"mapping":{"salidabodega_producto":"id"}})
     */
    public function listAction(MovimientosProductos $salidabodega_producto, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:MovimientosProductos')
            ->findAllByMovimientosProductosId($salidabodega_producto->getId());

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaBodega/Movimiento/MovimientosProductos/list_template.html.twig', array(
            'entities' => $entities,
            'salidabodega_producto' => $salidabodega_producto,
        ));
    }

    /**
     * @param Request $request
     *
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/new/modal/salidabodega_producto", name="salidabodega_productos_new_modal", methods={"GET"}, options={"expose":true})
     */
    public function newModalAction(Request $request)
    {
        $filter = new MovimientosProductosFilterModel();

        $form = $this->createForm(new MovimientosProductosFilter(), $filter, array(
            'action' => $this->generateUrl('salidabodega_productos_new_modal'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Producto')->filterProductos($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Producto')->findAll();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        $renderView = $this->renderView('@BusetaBodega/Movimiento/modal_form.html.twig', array(
            'form' => $form->createView(),
            'entities'      => $entities
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Lists all MovimientosProductos entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BusetaBodegaBundle:MovimientosProductos')->findAll();

        return $this->render('BusetaBodegaBundle:MovimientosProductos:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MovimientosProductos entity.
     */
    public function createAction(Request $request)
    {
        $entity = new MovimientosProductos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('linea_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:MovimientosProductos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function create_compraAction(Request $request)
    {
        $entity = new MovimientosProductos();
        $form = $this->createCreateCompraForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
        }
    }

    /**
     * Creates a form to create a MovimientosProductos entity.
     *
     * @param MovimientosProductos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MovimientosProductos $entity)
    {
        $form = $this->createForm(new MovimientosProductosType(), $entity, array(
            'action' => $this->generateUrl('linea_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to create a MovimientosProductos entity.
     *
     * @param MovimientosProductos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateCompraForm(MovimientosProductos $entity)
    {
        $form = $this->createForm(new MovimientosProductosType(), $entity, array(
                'action' => $this->generateUrl('linea_compra_create'),
                'method' => 'POST',
            ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MovimientosProductos entity.
     */
    public function newAction()
    {
        $entity = new MovimientosProductos();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:MovimientosProductos:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MovimientosProductos entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MovimientosProductos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientosProductos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:MovimientosProductos:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing MovimientosProductos entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MovimlineaientoProductoLinea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientosProductos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:MovimientosProductos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a MovimientosProductos entity.
     *
     * @param MovimientosProductos $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(MovimientosProductos $entity)
    {
        $form = $this->createForm(new MovimientosProductosType(), $entity, array(
            'action' => $this->generateUrl('linea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MovimientosProductos entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:MovimientosProductos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MovimientosProductos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('linea_edit', array('id' => $id)));
        }

        return $this->render('BusetaBodegaBundle:MovimientosProductos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MovimientosProductosLina entity.
     *
     * @Route("/{id}/delete_", name="salidabodega_producto_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(MovimientosProductos $salidabodegaProducto, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($salidabodegaProducto->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($salidabodegaProducto);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Línea de Movimiento de Producto'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/MovimientosProductos/Linea/delete_modal.html.twig', array(
            'entity' => $salidabodegaProducto,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('salidabodega_productos_list'));
    }

    /**
     * Creates a form to delete a MovimientosProductos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('linea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     *
     * CONTROLLER METHODS FOR NEW APPROACH
     *
     */

    /**
     * Lists all SalidaBodegaProducto entities.
     *
     * @Route("/{salida}", name="lineasdeproducto", options={"expose":true})
     *
     * @Method("GET")
     */
    public function indexLAction($salida, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('BusetaBodegaBundle:SalidaBodegaProducto')->findBySalida($salida);

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:SalidaBodegaProducto:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SalidaBodegaProducto entity.
     *
     * @Route("/create/{salida}", name="lineasdeproducto_create")
     * @ParamConverter("salida", options={"mapping":{"salida":"id"}})
     *
     * @Method("POST")
     */
    public function createLAction(SalidaBodega $salida, Request $request)
    {
        $entity = new SalidaBodegaProducto();
        $entity->setSalida($salida);

        $form = $this->createLCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $trans = $this->get('translator');

            $em->persist($entity);
            $em->flush();

            return new JsonResponse(array(
                'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle'),
            ), 201);
        }

        $renderView = $this->renderView('BusetaBodegaBundle:SalidaBodegaProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a SalidaBodegaProducto entity.
     *
     * @param SalidaBodegaProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLCreateForm(SalidaBodegaProducto $entity)
    {
        $form = $this->createForm(new SalidaBodegaProductoType(), $entity, array(
            'action' => $this->generateUrl('lineasdeproducto_create', array('salida' => $entity->getSalida()->getId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new SalidaBodegaProducto entity.
     *
     * @Route("/new/{salida}", name="lineasdeproducto_new", methods={"GET", "POST"}, options={"expose":true})
     * @ParamConverter("salida", options={"mapping":{"salida":"id"}})
     */
    public function newLAction(SalidaBodega $salida)
    {
        $entity = new SalidaBodegaProducto();
        $entity->setSalida($salida);

        $form   = $this->createLCreateForm($entity);

        $renderView = $this->renderView('BusetaBodegaBundle:SalidaBodegaProducto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Finds and displays a SalidaBodegaProducto entity.
     *
     * @Route("/{id}", name="lineasdeproducto_show")
     *
     * @Method("GET")
     * @Template()
     */
    public function showLAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:SalidaBodegaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalidaBodegaProducto entity.');
        }

        $deleteForm = $this->createLDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing SalidaBodegaProducto entity.
     *
     * @Route("/{id}/edit", name="lineasdeproducto_edit", options={"expose":true})
     *
     * @Method("GET")
     */
    public function editLAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:SalidaBodegaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalidaBodegaProducto entity.');
        }

        $editForm = $this->createLEditForm($entity);
        $deleteForm = $this->createLDeleteForm($id);

        $renderView = $this->renderView('BusetaBodegaBundle:SalidaBodegaProducto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

        return new JsonResponse(array('view' => $renderView), 202);
    }

    /**
     * Creates a form to edit a SalidaBodegaProducto entity.
     *
     * @param SalidaBodegaProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLEditForm(SalidaBodegaProducto $entity)
    {
        $form = $this->createForm(new SalidaBodegaProductoType(), $entity, array(
            'action' => $this->generateUrl('lineasdeproducto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing SalidaBodegaProducto entity.
     *
     * @Route("/{id}", name="lineasdeproducto_update")
     *
     * @Method("PUT")
     * @Template("BusetaBodegaBundle:SalidaBodegaProducto:edit.html.twig")
     */
    public function updateLAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:SalidaBodegaProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SalidaBodegaProducto entity.');
        }

        $deleteForm = $this->createLDeleteForm($id);
        $editForm = $this->createLEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lineasdeproducto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @param SalidaBodegaProducto $salidaBodegaProducto
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/{id}/delete", name="salidabodega_lineasdeproducto_delete", methods={"GET", "POST", "DELETE"}, options={"expose":true})
     */
    public function deleteLAction(SalidaBodegaProducto $salidaBodegaProducto, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createLDeleteForm($salidaBodegaProducto->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');
                $em->remove($salidaBodegaProducto);
                $em->flush();

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $trans->trans('messages.delete.success', array(), 'BusetaBodegaBundle'),
                    ), 202);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'SalidaBodegaProducto'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/SalidaBodegaProducto/delete_modal.html.twig', array(
            'entity' => $salidaBodegaProducto,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return new Response($renderView);
    }

    /**
     * Creates a form to delete a SalidaBodegaProducto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('salidabodega_lineasdeproducto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
