<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Extras\FuncionesExtras;
use Buseta\BodegaBundle\Form\Filtro\BusquedaInformeCostosType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class InformeCostosController
 *
 * @package Buseta\BodegaBundle\Controller
 *
 * @Route("/informecostos")
 */
class InformeCostosController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="bodega_informe_costos")
     * @Method({"GET", "POST"})
     */
    public function informeCostosAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $almacenesArray = null;
        $almacenesFinal= null;
        $informeCostos = $this->createForm(new BusquedaInformeCostosType());

        $informeCostos->handleRequest($request);
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

        return $this->render('@BusetaBodega/InformeCostos/index.html.twig', array(
            'entities' => $almacenesArray,
            'almacenes' => $almacenesFinal,
            'informeCostos' => $informeCostos->createView(),
        ));
    }
}
