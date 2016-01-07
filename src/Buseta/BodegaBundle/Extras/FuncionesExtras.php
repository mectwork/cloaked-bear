<?php

namespace Buseta\BodegaBundle\Extras;

use Buseta\TallerBundle\Entity\Impuesto;
use Buseta\BodegaBundle\Entity\InformeStock;
use Symfony\Component\Validator\Constraints\DateTime;

class FuncionesExtras
{
    public function ImporteLinea($cantidad_pedido, $precio_unitario, $impuesto = null, $porciento_descuento = 0)
    {
        $importeBruto       = $cantidad_pedido * $precio_unitario;
        $importeDescuento   = $importeBruto * $porciento_descuento / 100;
        $importeImpuesto    = 0;

        if ($impuesto) {
            $tipoImpuesto = $impuesto->getTipo();
            $tarifaImpuesto = $impuesto->getTarifa();

            if ($tipoImpuesto == "fijo") {
                $importeImpuesto = $tarifaImpuesto;
            } elseif ($tipoImpuesto == "porcentaje") {
                $importeImpuesto    = $importeBruto * $tarifaImpuesto / 100;
            }
        }

        return $importeBruto + $importeImpuesto - $importeDescuento;;
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
                    /** @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacora */
                    if ($producto == $bitacora->getProducto()) {
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                        if ($bitacora->getTipoMovimiento() == 'V+'
                            || $bitacora->getTipoMovimiento() == 'M+'
                            || $bitacora->getTipoMovimiento() == 'I+' ) {
                            $cantidadPedido += $bitacora->getCantidadMovida();
                        }
                        if ($bitacora->getTipoMovimiento() == 'M-'
                            || $bitacora->getTipoMovimiento() === 'P-') {
                            $cantidadPedido -= $bitacora->getCantidadMovida();
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
                    /** @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacora */
                    if ($producto == $bitacora->getProducto() && $bitacora->getAlmacen() == $almacen) {
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                        if ($bitacora->getTipoMovimiento() === 'V+'
                            || $bitacora->getTipoMovimiento() === 'M+'
                            || $bitacora->getTipoMovimiento() === 'I+') {
                            $cantidadPedido += $bitacora->getCantidadMovida();
                        }
                        if ($bitacora->getTipoMovimiento() === 'M-'
                            || $bitacora->getTipoMovimiento() === 'P-') {
                            $cantidadPedido -= $bitacora->getCantidadMovida();
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
            /** @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacora */
            //Si se encuentra en la bitácora el almacen y producto seleccionado
            if ($bitacora->getAlmacen() == $almacen && $bitacora->getProducto() == $producto) {
                $existe = true;
                //Comprobar tipo de movimiento para realizar operación de sustracción o adición
                //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                if ($bitacora->getTipoMovimiento() == 'V+'
                    || $bitacora->getTipoMovimiento() == 'M+'
                    || $bitacora->getTipoMovimiento() == 'I+') {
                    $cantidadPedido += $bitacora->getCantidadMovida();
                }
                if ($bitacora->getTipoMovimiento() == 'M-'
                    || $bitacora->getTipoMovimiento() === 'P-') {
                    $cantidadPedido -= $bitacora->getCantidadMovida();
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
                    /** @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacora */
                    if ($producto == $bitacora->getProducto() && $bitacora->getAlmacen() == $almacen) {
                        //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                        if ($bitacora->getTipoMovimiento() == 'V+'
                            || $bitacora->getTipoMovimiento() == 'M+'
                            || $bitacora->getTipoMovimiento() == 'I+') {
                            $cantidadPedido += $bitacora->getCantidadMovida();
                        }
                        if ($bitacora->getTipoMovimiento() == 'M-'
                            || $bitacora->getTipoMovimiento() === 'P-') {
                            $cantidadPedido -= $bitacora->getCantidadMovida();
                        }

                        foreach ($producto->getCostoProducto() as $costos) {
                            if ($costos->getActivo()) {
                                $costoProducto = ($costos->getCosto());
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
            /** @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacora */
            //Si se encuentra en la bitácora el almacen y producto seleccionado
            if ($bitacora->getAlmacen() == $almacen && $bitacora->getProducto() == $producto) {
                $existe = true;
                //Comprobar tipo de movimiento para realizar operación de sustracción o adición
                //Identifico el tipoMovimiento (NO SE HA IMPLEMENTADO COMPLETAMENTE AÚN)
                if ($bitacora->getTipoMovimiento() == 'V+'
                    || $bitacora->getTipoMovimiento() == 'M+'
                    || $bitacora->getTipoMovimiento() == 'I+') {
                    $cantidadReal += $bitacora->getCantidadMovida();
                }
                if ($bitacora->getTipoMovimiento() == 'M-'
                    || $bitacora->getTipoMovimiento() === 'P-') {
                    $cantidadReal -= $bitacora->getCantidadMovida();
                }
            }
        }

        return $cantidadReal;
    }

    /* Devuelve un booleano al comprobar si un Autobus se encuentra en la ListaNegraCombustible */
    public function comprobarAutobusesListaNegra($autobus, $em)
    {
        $listaNegrasCombustible = $em->getRepository('BusetaBusesBundle:ListaNegraCombustible')->findAll();
        $today = new \DateTime('now');

        foreach ($listaNegrasCombustible as $lista) {

            //Comprobar si el autobus se encuentra en la lista y la fecha actual
            if ($lista->getAutobus() == $autobus) {
                if($lista->getFechaInicio() <= $today && $lista->getFechaFinal() >= $today) {
                    return true;
                }
            }
        }

        return false;
    }
}
