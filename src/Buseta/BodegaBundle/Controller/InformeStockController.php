<?php

namespace Buseta\BodegaBundle\Controller;


use Buseta\BodegaBundle\Entity\InformeStock;
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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        //Recorro cada almacen
        foreach($almacenes as $almacen){

            //Obtengo la bitacora para el almacen actual
            $bitacoras = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->findBy(
                array(
                    'almacen' => $almacen
                )
            );

            $cantidadPedido = 0;

            //Busco cada producto existente para la bitacora actual
            foreach($productos as $producto)
            {
                foreach($bitacoras as $bitacora)
                {
                    if($producto == $bitacora->getProducto())
                    {
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO AÚN)
                        if($bitacora->getTipoMovimiento() == 'V+')
                        {
                            $cantidadPedido += $bitacora->getCantMovida();
                        }
                    }

                }

                //Actualizo el informeStock
                if($cantidadPedido != 0)
                {
                    $informeStockExistente = $em->getRepository('BusetaBodegaBundle:InformeStock')->findOneBy(
                        array(
                            'almacen' => $almacen,
                            'producto' => $producto,
                        )
                    );

                    if($informeStockExistente)
                    {
                        $informeStockExistente->setCantidadProductos($cantidadPedido);
                        $em->persist($informeStockExistente);
                        $em->flush();
                    }
                    else
                    {
                        $informeStock = new InformeStock();
                        $informeStock->setProducto($producto);
                        $informeStock->setAlmacen($almacen);
                        $informeStock->setCantidadProductos($cantidadPedido);
                        $em->persist($informeStock);
                        $em->flush();
                    }
                }

                //Reinicio cantidad de pedidos
                $cantidadPedido = 0;

            }

        }

        $entities = $em->getRepository('BusetaBodegaBundle:InformeStock')->findAll();

        /*$paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            5,
            array('pageParameterName' => 'page')
        );*/

        return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
            'entities' => $entities,
            'almacenes' => $almacenes,
        ));
    }


}
