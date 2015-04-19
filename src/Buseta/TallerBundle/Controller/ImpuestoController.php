<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\BodegaBundle\Entity\CostoProducto;
use Buseta\BodegaBundle\Entity\Producto;
use Buseta\TallerBundle\Form\Filter\ImpuestoFilter;
use Buseta\TallerBundle\Form\Model\ImpuestoFilterModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\TallerBundle\Entity\Impuesto;
use Buseta\TallerBundle\Form\Type\ImpuestoType;
use Buseta\BodegaBundle\Extras\FuncionesExtras;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Impuesto controller.
 *
 * @Route("/impuesto")
 */
class ImpuestoController extends Controller
{
    /**
     * Updated automatically select All when change select Impuesto.
     */
    public function select_impuesto_productos_allAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->getDoctrine()->getManager();

        /** @var Producto $producto */
        $producto = $em->getRepository('BusetaBodegaBundle:Producto')->findOneBy(array(
            'id' => $request->query->get('producto_id'),
        ));

        /** @var Impuesto $impuesto */
        $impuesto = $em->getRepository('BusetaTallerBundle:Impuesto')->findOneBy(array(
            'id' => $request->query->get('impuesto_id'),
        ));

        $cantidad_pedido  = $request->query->get('cantidad_pedido');
        foreach ($producto->getCostoProducto() as $costo) {
            /** @var CostoProducto $costo */
            if ($costo->getActivo()) {
                $precioSalida = ($costo->getCosto());
            }
        }

        if(isset($precioSalida))  {
            $precio_unitario = $precioSalida;
        }
        else{
            $precio_unitario = 0;
        }

        $porciento_descuento = $request->query->get('porciento_descuento');

        $funcionesExtras = new FuncionesExtras();
        $importeLinea = $funcionesExtras->ImporteLinea($cantidad_pedido, $precio_unitario, $impuesto, $porciento_descuento);

        $json = array(
            'importeLinea' => $importeLinea,
            'precio' => $precio_unitario,
            'uom' => $producto->getUom()->getId(),
        );

        return new \Symfony\Component\HttpFoundation\JsonResponse($json);
    }

    /**
     * Lists all Impuesto entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new ImpuestoFilterModel();

        $form = $this->createForm(new ImpuestoFilter(), $filter, array(
            'action' => $this->generateUrl('impuesto'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Impuesto')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Impuesto')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('BusetaTallerBundle:Impuesto:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Impuesto entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Impuesto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('impuesto_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaTallerBundle:Impuesto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Impuesto entity.
     *
     * @param Impuesto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Impuesto $entity)
    {
        $form = $this->createForm(new ImpuestoType(), $entity, array(
            'action' => $this->generateUrl('impuesto_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Impuesto entity.
     */
    public function newAction()
    {
        $entity = new Impuesto();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:Impuesto:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Impuesto entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Impuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Impuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:Impuesto:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Impuesto entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Impuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Impuesto entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:Impuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Impuesto entity.
     *
     * @param Impuesto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Impuesto $entity)
    {
        $form = $this->createForm(new ImpuestoType(), $entity, array(
            'action' => $this->generateUrl('impuesto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Impuesto entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Impuesto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Impuesto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('impuesto_show', array('id' => $id)));
        }

        return $this->render('BusetaTallerBundle:Impuesto:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Impuesto entity.
     *
     * @Route("/{id}/delete", name="impuesto_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(Impuesto $impuesto, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($impuesto->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($impuesto);
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
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Impuesto'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaTaller/Impuesto/delete_modal.html.twig', array(
            'entity' => $impuesto,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('impuesto'));
    }

    /**
     * Creates a form to delete a Impuesto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('impuesto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
