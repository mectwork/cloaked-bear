<?php

namespace Buseta\BodegaBundle\Extras;

use Buseta\TallerBundle\Entity\Impuesto;
use Buseta\BodegaBundle\Entity\InformeStock;

class FuncionesExtras
{
    public function ImporteLinea($impuesto, $cantidad_pedido, $precio_unitario, $porciento_descuento)
    {
        $importeLinea = 0;

        if ($impuesto) {
            $tipoImpuesto = $impuesto->getTipo();
            $tarifaImpuesto = $impuesto->getTarifa();

            if ($tipoImpuesto == "fijo") {
                $importeLinea = ($cantidad_pedido * $precio_unitario) + $tarifaImpuesto;
                $importeDescuento = $importeLinea * $porciento_descuento / 100;
                $importeLinea = $importeLinea - $importeDescuento;
            } elseif ($tipoImpuesto == "porcentaje") {
                $importeImpuesto = ($cantidad_pedido * $precio_unitario) * $tarifaImpuesto / 100;
                $importeLinea = ($cantidad_pedido * $precio_unitario) + $importeImpuesto;
                $importeDescuento = $importeLinea * $porciento_descuento / 100;
                $importeLinea = $importeLinea - $importeDescuento;
            }
        }

        return $importeLinea;
    }

    public function ActualizarInformeStock($busqueda, $em)
    {
        $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $datos = $busqueda->getData();

        //Recorro cada almacen
        foreach ($almacenes as $almacen) {

            //Obtengo la bitacora para el almacen actual
            $bitacoras = $em->getRepository('BusetaBodegaBundle:InformeStock')->buscarAlmacenBitacora($almacen,
                $datos['fecha']);

            $cantidadPedido = 0;

            //Busco cada producto existente para la bitacora actual
            foreach ($productos as $producto) {
                foreach ($bitacoras as $bitacora) {
                    if ($producto == $bitacora->getProducto()) {
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                        if ($bitacora->getTipoMovimiento() == 'V+' || $bitacora->getTipoMovimiento() == 'M+' || $bitacora->getTipoMovimiento() == 'I+' ) {
                            $cantidadPedido += $bitacora->getCantMovida();
                        }
                        if ($bitacora->getTipoMovimiento() == 'M-') {
                            $cantidadPedido -= $bitacora->getCantMovida();
                        }
                    }
                }

                //Actualizo el informeStock
                if ($cantidadPedido != 0) {
                    $informeStockExistente = $em->getRepository('BusetaBodegaBundle:InformeStock')->findOneBy(
                        array(
                            'almacen' => $almacen,
                            'producto' => $producto,
                        )
                    );

                    if ($informeStockExistente) {
                        $informeStockExistente->setCantidadProductos($cantidadPedido);
                        $em->persist($informeStockExistente);
                        $em->flush();
                    } else {
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

    public function generarInformeStock($bitacoras, $em)
    {
        $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $almacenesArray = array(array());
        $pos = 0;
        $almacenesArray[$pos]['almacen'] = null;
        $almacenesArray[$pos]['producto'] = null;
        $almacenesArray[$pos]['cantidad'] = null;

        //Recorro cada almacen
        foreach ($almacenes as $almacen) {
            $cantidadPedido = 0;

            //Busco cada producto existente para la bitacora actual
            foreach ($productos as $producto) {
                foreach ($bitacoras as $bitacora) {
                    if ($producto == $bitacora->getProducto() && $bitacora->getAlmacen() == $almacen) {
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                        if ($bitacora->getTipoMovimiento() == 'V+' || $bitacora->getTipoMovimiento() == 'M+' || $bitacora->getTipoMovimiento() == 'I+') {
                            $cantidadPedido += $bitacora->getCantMovida();
                        }
                        if ($bitacora->getTipoMovimiento() == 'M-') {
                            $cantidadPedido -= $bitacora->getCantMovida();
                        }
                    }
                }

                //Actualizo el informeStock
                if ($cantidadPedido != 0) {
                    $almacenesArray[$pos]['almacen'] = $almacen;
                    $almacenesArray[$pos]['producto'] = $producto;
                    $almacenesArray[$pos]['cantidad'] = $cantidadPedido;
                    $pos += 1;
                }

                //Reinicio cantidad de pedidos
                $cantidadPedido = 0;
            }
        }

        return $almacenesArray;
    }

    public function comprobarCantProductoAlmacen($producto, $almacen, $cantidad, $em)
    {
        $cantidadPedido = 0;
        $existe = false;
        $bitacoras = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->findAll();

        foreach ($bitacoras as $bitacora) {
            //Si se encuentra en la bitácora el almacen y producto seleccionado
            if ($bitacora->getAlmacen() == $almacen && $bitacora->getProducto() == $producto) {
                $existe = true;
                //Comprobar tipo de movimiento para realizar operación de sustracción o adición
                //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                if ($bitacora->getTipoMovimiento() == 'V+' || $bitacora->getTipoMovimiento() == 'M+' || $bitacora->getTipoMovimiento() == 'I+') {
                    $cantidadPedido += $bitacora->getCantMovida();
                }
                if ($bitacora->getTipoMovimiento() == 'M-') {
                    $cantidadPedido -= $bitacora->getCantMovida();
                }
            }
        }

        if ($existe) {
            return $cantidadPedido - $cantidad;
        }

        return 'No existe';
    }

    public function generarInformeCostos($bitacoras, $em)
    {
        $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();
        $productos = $em->getRepository('BusetaBodegaBundle:Producto')->findAll();

        $almacenesArray = array(array());
        $pos = 0;
        $almacenesArray[$pos]['almacen'] = null;
        $almacenesArray[$pos]['producto'] = null;
        $almacenesArray[$pos]['cantidad'] = null;
        $almacenesArray[$pos]['costos'] = null;

        //Recorro cada almacen
        foreach ($almacenes as $almacen) {
            $cantidadPedido = 0;
            $costos = 0;

            //Busco cada producto existente para la bitacora actual
            foreach ($productos as $producto) {
                foreach ($bitacoras as $bitacora) {
                    if ($producto == $bitacora->getProducto() && $bitacora->getAlmacen() == $almacen) {
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                        if ($bitacora->getTipoMovimiento() == 'V+' || $bitacora->getTipoMovimiento() == 'M+' || $bitacora->getTipoMovimiento() == 'I+') {
                            $cantidadPedido += $bitacora->getCantMovida();
                        }
                        if ($bitacora->getTipoMovimiento() == 'M-') {
                            $cantidadPedido -= $bitacora->getCantMovida();
                        }

                        foreach ($producto->getPrecioProducto() as $precios) {
                            if ($precios->getActivo()) {
                                $costoProducto = ($precios->getCosto());
                            }
                        }
                        $costos = $cantidadPedido * $costoProducto;
                    }
                }

                //Actualizo el informeStock
                if ($cantidadPedido != 0) {
                    $almacenesArray[$pos]['almacen'] = $almacen;
                    $almacenesArray[$pos]['producto'] = $producto;
                    $almacenesArray[$pos]['cantidad'] = $cantidadPedido;
                    $almacenesArray[$pos]['costos'] = $costos;
                    $pos += 1;
                }

                //Reinicio cantidad de pedidos
                $costos = 0;
            }
        }

        return $almacenesArray;
    }

    public function obtenerCantidaProductosAlmancen($producto, $almacen, $em)
    {

        $cantidadReal = 0;
        $existe = false;
        //Obtengo las bitacoras
        $bitacoras = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->findAll();

        foreach ($bitacoras as $bitacora) {
            //Si se encuentra en la bitácora el almacen y producto seleccionado
            if ($bitacora->getAlmacen() == $almacen && $bitacora->getProducto() == $producto) {
                $existe = true;
                //Comprobar tipo de movimiento para realizar operación de sustracción o adición
                //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                if ($bitacora->getTipoMovimiento() == 'V+' || $bitacora->getTipoMovimiento() == 'M+' || $bitacora->getTipoMovimiento() == 'I+') {
                    $cantidadReal += $bitacora->getCantMovida();
                }
                if ($bitacora->getTipoMovimiento() == 'M-') {
                    $cantidadReal -= $bitacora->getCantMovida();
                }
            }
        }

        return $cantidadReal;
    }
}
