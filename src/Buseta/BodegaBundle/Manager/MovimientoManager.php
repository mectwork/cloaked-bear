<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class AlbaranManager
 * @package Buseta\BodegaBundle\Manager
 */
class MovimientoManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     */
    function __construct(ObjectManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }


    public function create()
    {

    }

    /**
     * Action take place to process Albaran
     *
     * @param Albaran $albaran
     * @return bool
     * @throws NotValidStateException
     */
    public function crear()
    {
           /* if ($albaran->getEstadoDocumento() !== 'DR') {
                $this->logger->error(sprintf('El estado %s del Albaran con id %d no se corresponde con el estado previo a procesado(PO).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                ));
                throw new NotValidStateException();
            }*/

        //        $entity = new Movimiento();
//        $form = $this->createCreateForm($entity);
//        $form->handleRequest($request);
//
//        if ($form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $fechaMovimiento = new \DateTime();
//
//            $request = $this->get('request');
//            $datos = $request->request->get('buseta_bodegabundle_movimiento');
//
//            //Comparar la existencia de cantidad de productos disponibles en el almacen
//            //a partir de la solicitud de movimiento de productos entre almacenes
//
//            $idAlmacenOrigen  = $datos['almacenOrigen'];
//            $idAlmacenDestino = $datos['almacenDestino'];
//
//            $movimientos = $datos['movimientos_productos'];
//
//            $cantidadDisponible = 0;
//
//            foreach ($movimientos as $movimiento) {
//                $idProducto = $movimiento['producto'];
//
//                $producto           = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
//                $almacen            = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
//                $cantidadProducto   = $movimiento['cantidad'];
//
//                $fe = new FuncionesExtras();
//                $cantidadDisponible = $fe->comprobarCantProductoAlmacen($producto, $almacen, $cantidadProducto, $em);
//
//                //Comprobar la existencia del producto en la bodega seleccionada
//                if ($cantidadDisponible == 'No existe') {
//                    //Volver al menu de de crear nuevo Movimiento
//                    $movimientosProductos = $this->createForm(new MovimientosProductosType());
//
//                    $form   = $this->createCreateForm($entity);
//                    $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
//                    $bodega   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
//
//                    $form->addError(new FormError("El producto '".$producto->getNombre()."' no existe en la bodega seleccionada"));
//
//                    return $this->render('BusetaBodegaBundle:Movimiento:new.html.twig', array(
//                        'entity' => $entity,
//                        'movimientosProductos' => $movimientosProductos->createView(),
//                        'form'   => $form->createView(),
//                    ));
//                }
//                //Si no existe la cantidad solicitada en el almacen del producto seleccionado
//                elseif ($cantidadDisponible < 0) {
//                    //Volver al menu de de crear nuevo Movimiento
//                    $movimientosProductos = $this->createForm(new MovimientosProductosType());
//
//                    $form   = $this->createCreateForm($entity);
//                    $producto = $em->getRepository('BusetaBodegaBundle:Producto')->find($idProducto);
//                    $bodega   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
//
//                    $form->addError(new FormError("No existe en la bodega '".$bodega->getNombre()."' la cantidad de productos solicitados para el producto: ".$producto->getNombre()));
//
//                    return $this->render('BusetaBodegaBundle:Movimiento:new.html.twig', array(
//                        'entity' => $entity,
//                        'movimientosProductos' => $movimientosProductos->createView(),
//                        'form'   => $form->createView(),
//                    ));
//                }
//                //Si sí existe la cantidad del producto en la bodega seleccionada
//                else {
//
//
//                    //Actualizar Bitácora - AlmacenOrigen
//                    $bitacora = new BitacoraAlmacen();
//                    $bitacora->setProducto($producto);
//                    $bitacora->setFechaMovimiento($fechaMovimiento);
//                    $origen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
//                    $bitacora->setAlmacen($origen);
//                    $bitacora->setCantMovida($movimiento['cantidad']);
//
//                    $eventDispatcher = $this->get('event_dispatcher');
//                    $event = new FilterBitacoraEvent($bitacora);
//                    $eventDispatcher->dispatch(BusetaBodegaBitacoraEvents::MOVEMENT_FROM /*M-*/, $event);
//
//                    //$bitacora->setTipoMovimiento('M-');
//                    //$em->persist($bitacora);
//                    //$em->flush();
//
//                    //Actualizar Bitácora - AlmacenDestino
//                    $bitacora = new BitacoraAlmacen();
//                    $bitacora->setProducto($producto);
//                    $bitacora->setFechaMovimiento($fechaMovimiento);
//                    $destino = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenDestino);
//                    $bitacora->setAlmacen($destino);
//                    $bitacora->setCantMovida($movimiento['cantidad']);
//
//                    $event = new FilterBitacoraEvent($bitacora);
//                    $eventDispatcher->dispatch(BusetaBodegaBitacoraEvents::MOVEMENT_TO /*M+*/, $event);
//
//                    //$bitacora->setTipoMovimiento('M+');
//                    //$em->persist($bitacora);
//                    //$em->flush();
//
//                    $almacenOrigen    = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenOrigen);
//                    $almacenDestino   = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenDestino);
//
//                    //Persistimos los movimientos
//                    $entity->setCreatedBy($this->getUser()->getUsername());
//                    $entity->setMovidoBy($this->getUser()->getUsername());
//                    $entity->setAlmacenOrigen($almacenOrigen);
//                    $entity->setAlmacenDestino($almacenDestino);
//                    $entity->setFechaMovimiento($fechaMovimiento);
//                    $em->persist($entity);
//                    $em->flush();
//                }
//            }
//
//            return $this->redirect($this->generateUrl('movimiento_show', array('id' => $entity->getId())));
//        }
//
//        return $this->render('BusetaBodegaBundle:Movimiento:new.html.twig', array(
//            'entity' => $entity,
//            'form'   => $form->createView(),
//        ));











        try {
            $this->em->persist($albaran);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar Albaran: %s', $e->getMessage()));

            return false;
        }
    }


}
