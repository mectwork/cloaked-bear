<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Form\Filtro\BusquedaInformeCostosType;
use Buseta\BodegaBundle\Form\Filtro\BusquedaMovimientoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
/**
 * Informe controller.
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

    public function busquedaAvanzadaAction($page, $cantResult)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $request = $this->getRequest();

        $orderBy = $request->query->get('orderBy');
        $filter  = $request->query->get('filter');

        $filter = $filter;

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

    public function informeCostosAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $informeCostos = $this->createForm(new BusquedaInformeCostosType());

        if ($request->getMethod() === 'POST') {
            $informeCostos->submit($request);

            if ($informeCostos->isValid()) {
                //Se obtienen todas las bitacoras que cumplieron con el filtro de búsqueda
                $bitacoras = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->busquedaBitacoraAlmacen($informeCostos);
                $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();

                $funcionesExtras = new FuncionesExtras();
                $almacenesArray = $funcionesExtras->generarInformeCostos($bitacoras, $em);

                $almacenesFinal = null;
                $pos = 0;

                foreach ($almacenes as $almacen) {
                    foreach ($almacenesArray as $almacenArray) {
                        if ($almacen == $almacenArray['almacen']) {
                            $almacenesFinal[$pos] = $almacen;
                            $pos++;
                            break;
                        }
                    }
                }
            }

            return $this->render('BusetaBodegaBundle:Informe:informeCostos.html.twig', array(
                'entities' => $almacenesArray,
                'almacenes' => $almacenesFinal,
                'informeCostos' => $informeCostos->createView(),
            ));
        } else {
            return $this->render('BusetaBodegaBundle:Informe:informeCostos.html.twig', array(
                'entities' => null,
                'almacenes' => null,
                'informeCostos' => $informeCostos->createView(),
            ));
        }
    }
}
