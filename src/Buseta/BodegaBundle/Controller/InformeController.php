<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Form\Filtro\BusquedaInformeCostosType;
use Buseta\BodegaBundle\Form\Filtro\BusquedaMovimientoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

/**
 * Informe controller.
 *
 * @Route("/informe")
 *
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Bodegas", routeName="bodega_principal")
 * @Breadcrumb(title="Informe de Movimientos")
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

    public function busquedaAvanzadaAction($page, $cantResult, Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $orderBy = $request->query->get('orderBy');
        $filter  = $request->query->get('filter');

        $busqueda = $em->getRepository('BusetaBodegaBundle:Movimiento')
            ->busquedaAvanzada($page, $cantResult, $filter, $orderBy);
        $paginacion = $busqueda['paginacion'];
        $results    = $busqueda['results'];

        return $this->render('BusetaBodegaBundle:Extras/table:busqueda-avanzada-movimientos.html.twig', array(
            'movimientos'   => $results,
            'page'       => $page,
            'cantResult' => $cantResult,
            'orderBy'    => $orderBy,
            'paginacion' => $paginacion,
        ));
    }
}
