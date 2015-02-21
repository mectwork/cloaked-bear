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

    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $informeStock = $this->createForm(new BusquedaInformeStockType());

        if($request->getMethod() === 'POST'){

            $informeStock->submit($request);

            if($informeStock->isValid()){

                //Se obtienen todas las bitacoras que cumplieron con el filtro de búsqueda
                $bitacoras = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->busquedaBitacoraAlmacen($informeStock);
                $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();

                $funcionesExtras = new FuncionesExtras();
                $almacenesArray = $funcionesExtras->generarInformeStock($bitacoras, $em);
                $almacenesFinal = null;
                $pos = 0;


                foreach($almacenes as $almacen)
                {

                    foreach($almacenesArray as $almacenArray)
                    {
                        if($almacen == $almacenArray['almacen'])
                        {
                            $almacenesFinal[$pos] = $almacen;
                            $pos++;
                            break;
                        }
                    }
                }

            }


            return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
                'entities' => $almacenesArray,
                'almacenes' => $almacenesFinal,
                'informeStock' => $informeStock->createView(),
            ));


        }
        else
        {
            return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
                'entities' => null,
                'almacenes' => null,
                'informeStock' => $informeStock->createView(),
            ));
        }


        /*//CASO BUSQUEDA
        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();

        return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
            'entities' => $entities,
            'almacenes' => $almacenes,
            'informeStock' => $informeStock->createView(),
        ));*/

    }

}
