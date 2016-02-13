<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\InformeStock;
use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Form\Filtro\BusquedaInformeStockType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
/**
 * informeStock controller.
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Bodegas", routeName="bodega_principal")
 */

class InformeStockController extends Controller
{
/**
 * Lists all Informe de Stock entities.
 * @Breadcrumb(title="Informe de Stock", routeName="informeStock")
*/
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $informeStock = $this->createForm(new BusquedaInformeStockType());

        if ($request->getMethod() === 'POST') {
            $informeStock->submit($request);

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
        } else {
            return $this->render('BusetaBodegaBundle:InformeStock:index.html.twig', array(
                'entities' => null,
                'almacenes' => null,
                'informeStock' => $informeStock->createView(),
            ));
        }
    }
}
