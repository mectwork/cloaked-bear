<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Form\Filter\BodegaFilter;
use Buseta\BodegaBundle\Form\Model\BodegaFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\Bodega;
use Buseta\BodegaBundle\Form\Type\BodegaType;
use Buseta\BodegaBundle\Form\Filtro\BusquedaAlmacenType;
use Buseta\BodegaBundle\Extras\FuncionesExtras;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Bodega controller.
 *
 * @Route("/bodega")
 */
class BodegaController extends Controller
{
    /**
     * Module Bodega entiy.
     */
    public function principalAction()
    {
        return $this->render('BusetaBodegaBundle:Default:principal.html.twig');
    }

    /**
     * Lists all Bodega entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new BodegaFilterModel();

        $form = $this->createForm(new BodegaFilter(), $filter, array(
            'action' => $this->generateUrl('bodega'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Bodega')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:Bodega')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:Bodega:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Bodega entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Bodega();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bodega_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Bodega:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Bodega entity.
     *
     * @param Bodega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Bodega $entity)
    {
        $form = $this->createForm(new BodegaType(), $entity, array(
            'action' => $this->generateUrl('bodega_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Bodega entity.
     */
    public function newAction()
    {
        $entity = new Bodega();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaBodegaBundle:Bodega:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bodega entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bodega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Bodega:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Bodega entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bodega entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Bodega:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Bodega entity.
     *
     * @param Bodega $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Bodega $entity)
    {
        $form = $this->createForm(new BodegaType(), $entity, array(
            'action' => $this->generateUrl('bodega_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Bodega entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bodega entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bodega_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Bodega:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Bodega entity.
     *
     * @Route("/{id}/delete", name="bodega_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(Bodega $bodega, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($bodega->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($bodega);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Bodega'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaBodega/Bodega/delete_modal.html.twig', array(
            'entity' => $bodega,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('bodega'));
    }

    /**
     * Creates a form to delete a Bodega entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bodega_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Updated automatically select All when change select Producto.
     */
    public function select_bodega_productos_allAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        $request = $this->getRequest();
        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();

        //Obtengo el producto seleccionado
        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->findOneBy(array(
            'id' => $request->query->get('producto_id'),
        ));

        //Obtengo el almacen seleccionado
        $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->findOneBy(array(
            'id' => $request->query->get('almacen_id'),
        ));

        $funcionesExtras = new FuncionesExtras();
        $cantidadReal = $funcionesExtras->obtenerCantidadProductosAlmancen($producto, $almacen, $em);

        $json = array(
            'cantidadReal' => $cantidadReal,
        );

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    public function productoTopeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($id);


        $productotopeList = $em->getRepository('BusetaBodegaBundle:ProductoTope')->findBy(
            array(
                'almacen' => $almacen,
            )
        );

        $productotopeArray = array();

        /*  @var  \Buseta\BodegaBundle\Entity\ProductoTope  $pt*/
        $fe = new FuncionesExtras();
        foreach ($productotopeList as $pt) {
            $producto = $pt->getProducto();
            $productotopeElem['prodtope']=$pt;
            $cantidadDisponible = $fe->obtenerCantidadProductosAlmancen($producto,$almacen,$em);
            $productotopeElem['cantidad']=$cantidadDisponible;
            $productotopeArray[]=$productotopeElem;
        }

        $paginator = $this->get('knp_paginator');
        $productotopeArray = $paginator->paginate(
            $productotopeArray,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaBodegaBundle:Bodega:productotope.html.twig', array(
            'productotope' => $productotopeArray,
            'almacen' => $almacen,
        ));
    }
}
