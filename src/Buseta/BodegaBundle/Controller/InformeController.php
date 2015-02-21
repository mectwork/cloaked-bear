<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Form\Filtro\BusquedaMovimientoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Informe controller.
 *
 */
class InformeController extends Controller
{
    public function informeMovimientosAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $movimiento = $this->createForm(new BusquedaMovimientoType());

        return $this->render('BusetaBodegaBundle:Informe:informeMovimientos.html.twig', array(
            'movimiento' => $movimiento->createView(),
        ));
    }

    public function busquedaAvanzadaAction($page,$cantResult){
        $em = $this->get('doctrine.orm.entity_manager');
        $request = $this->getRequest();

        $orderBy = $request->query->get('orderBy');
        $filter  = $request->query->get('filter');

        $filter = $filter;

        $busqueda = $em->getRepository('BusetaBodegaBundle:Movimiento')
            ->busquedaAvanzada($page,$cantResult,$filter,$orderBy);
        $paginacion = $busqueda['paginacion'];
        $results    = $busqueda['results'];

        return $this->render('BusetaBodegaBundle:Extras/table:busqueda-avanzada-movimientos.html.twig',array(
            'movimientos'   => $results,
            'page'       => $page,
            'cantResult' => $cantResult,
            'orderBy'    => $orderBy,
            'paginacion' => $paginacion,
        ));
    }
}
