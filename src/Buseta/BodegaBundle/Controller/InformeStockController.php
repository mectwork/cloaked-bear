<?php

namespace Buseta\BodegaBundle\Controller;


use Buseta\BodegaBundle\Entity\InformeStock;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Form\Filtro\BusquedaInformeStockType;
use Symfony\Component\HttpFoundation\Request;
use Buseta\BodegaBundle\Form\Model\InformeStockModel;
use Buseta\BodegaBundle\Form\Type\InformeStockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InformeStockController extends Controller
{

    /**
     * Lists all InformeStock entities.
     *
     */
    /*public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $funcionesExtras = new FuncionesExtras();

        //Se actualiza la informacion del InformeStock
        $funcionesExtras->ActualizarInformeStock($em);

        $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();
        $entities = $em->getRepository('BusetaBodegaBundle:InformeStock')->findAll();

        return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
            'entities' => $entities,
            'almacenes' => $almacenes,
        ));


    }*/
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $informeStock = $this->createForm(new BusquedaInformeStockType());

        if($request->getMethod() === 'GET'){
            $informeStock->submit($request);

            if($informeStock->isValid()){

                $entities = $em->getRepository('BusetaBodegaBundle:InformeStock')->buscarInformeStock($informeStock);
            }
        }
        else
        {
            $entities = $em->getRepository('BusetaBusesBundle:InformeStock')->buscarTodos($em);
        }

        //CASO BUSQUEDA-AUTOBUS
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
            'entities' => $entities,
            'informeStock' => $informeStock->createView(),
        ));

    }


}
