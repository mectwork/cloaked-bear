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
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/informeMovimiento", name="movimiento_informe")
     * @Method({"GET"})
     */
    public function informeMovimientosAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $movimiento = $this->createForm(new BusquedaMovimientoType());

        return $this->render('BusetaBodegaBundle:Informe:informeMovimientos.html.twig', array(
            'movimiento' => $movimiento->createView(),
        ));
    }

    /**
     * @param         $page
     * @param         $cantResult
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/busqueda-avanzada/{page}/{cantResult}", name="salidabodega_ajax_busqueda_avanzada",
     *     defaults={"page": 0, "cantResult": 10})
     * @Method({"GET"})
     */
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
