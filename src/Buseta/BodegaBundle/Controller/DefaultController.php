<?php

namespace Buseta\BodegaBundle\Controller;


use Buseta\BodegaBundle\Entity\InformeStock;
use Symfony\Component\HttpFoundation\Request;
use Buseta\BodegaBundle\Form\Model\InformeStockModel;
use Buseta\BodegaBundle\Form\Type\InformeStockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function informeStockAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $informeStock = $em->getRepository('BusetaBodegaBundle:InformeStock')->findAll();

        $paginator = $this->get('knp_paginator');
        $informeStock = $paginator->paginate(
            $informeStock,
            $this->get('request')->query->get('page', 1),
            5,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
            'entities' => $informeStock,
        ));
    }

    /**
     *
     * @param InformeStockModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(InformeStockModel $entity)
    {
        $form = $this->createForm(new InformeStockType(), $entity, array(
            'action' => $this->generateUrl('informe_stock_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a new InformeStockModel entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new InformeStockModel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('BusetaBodegaBundle:Producto')->informeStock($form,$em);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('informe_stock_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaBodegaBundle:Default:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InformeStockModel entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:Default')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InformeStockModel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaBodegaBundle:Default:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }


}
