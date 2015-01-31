<?php

namespace Buseta\BodegaBundle\Extras;

use Buseta\TallerBundle\Entity\Impuesto;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\ORM\EntityRepository;
use Buseta\BodegaBundle\Entity\InformeStock;

class FuncionesExtras
{
    public function ImporteLinea($impuesto, $cantidad_pedido, $precio_unitario, $porciento_descuento)
    {
        $importeLinea = 0;

        if($impuesto){
            $tipoImpuesto   = $impuesto->getTipo();
            $tarifaImpuesto = $impuesto->getTarifa();

            if($tipoImpuesto == "fijo")
            {
                $importeLinea     = ($cantidad_pedido * $precio_unitario) + $tarifaImpuesto;
                $importeDescuento = $importeLinea * $porciento_descuento / 100;
                $importeLinea     = $importeLinea - $importeDescuento;
            }
            elseif($tipoImpuesto == "porcentaje")
            {
                $importeImpuesto  = ($cantidad_pedido * $precio_unitario) * $tarifaImpuesto / 100;
                $importeLinea     = ($cantidad_pedido * $precio_unitario) + $importeImpuesto;
                $importeDescuento = $importeLinea * $porciento_descuento / 100;
                $importeLinea     = $importeLinea - $importeDescuento;
            }
        }

        return $importeLinea;
    }

    public function ActualizarInformeStock($em){
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
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                        if($bitacora->getTipoMovimiento() == 'V+' || $bitacora->getTipoMovimiento() == 'M+')
                        {
                            $cantidadPedido += $bitacora->getCantMovida();
                        }
                        if($bitacora->getTipoMovimiento() == 'M-')
                        {
                            $cantidadPedido -= $bitacora->getCantMovida();
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
    }
}
?>