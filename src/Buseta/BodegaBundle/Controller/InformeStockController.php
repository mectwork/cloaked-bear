<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Form\Filtro\BusquedaInformeStockType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

/**
 * Class InformeStockController
 *
 * @package Buseta\BodegaBundle\Controller
 *
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Bodegas", routeName="bodega_principal")
 *
 * @Route("/informe_stock")
 */
class InformeStockController extends Controller
{
    /**
     * Lists all Informe de Stock entities.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="bodega_informe_stock")
     * @Method({"GET", "POST"})
     *
     * @Breadcrumb(title="Informe de Stock", routeName="bodega_informe_stock")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $almacenesArray = null;
        $almacenesFinal = null;
        $informeStock = $this->createForm(new BusquedaInformeStockType());

        $informeStock->handleRequest($request);
        if ($informeStock->isValid()) {
            //Se obtienen todas las bitacoras que cumplieron con el filtro de búsqueda
            $bitacoras = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->busquedaBitacoraAlmacen($informeStock);
            $almacenes = $em->getRepository('BusetaBodegaBundle:Bodega')->findAll();

            $funcionesExtras = new FuncionesExtras();
            $almacenesArray = $funcionesExtras->generarInformeStock($bitacoras, $em);
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

        return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
            'entities' => $almacenesArray,
            'almacenes' => $almacenesFinal,
            'informeStock' => $informeStock->createView(),
        ));
    }
}
