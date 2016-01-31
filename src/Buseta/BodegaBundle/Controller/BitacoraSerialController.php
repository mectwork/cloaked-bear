<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\Producto;

use Buseta\BodegaBundle\Form\Filter\BitacoraSerialFilter;

use Buseta\BodegaBundle\Form\Model\BitacoraSerialFilterModel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\BitacoraSerial;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * BitacoraSerial controller.
 *
 * @Route("bodega/bitacoraserial")
 */
class BitacoraSerialController extends Controller
{

    /**
     * Lists all BitacoraSerial entities.
     *
     * @Route("/", name="bitacoraserial")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $filter = new BitacoraSerialFilterModel();

        $form = $this->createForm(new BitacoraSerialFilter(), $filter, array(
            'action' => $this->generateUrl('bitacoraserial'),
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraSerial')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraSerial')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:BitacoraSerial:index.html.twig', array(
            'entities' => $entities,
            'filter_form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing BitacoraSerial entity.
     *
     * @Route("/{id}/show", name="bitacoraserial_show", methods={"GET"}, options={"expose":true})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:BitacoraSerial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BitacoraSerial entity.');
        }

        return $this->render('BusetaBodegaBundle:BitacoraSerial:show.html.twig', array(
            'entity' => $entity
        ));
    }

    //A partir de aqui los metodos requeridos para el AJAX que llama desde el formulario de Producto

    /**
     * Displays a form to edit an existing BitacoraSerial entity.
     *
     * @Route("/listarporproducto/{id}", name="bitacoraserial_listarpor_producto", methods={"GET"}, options={"expose":true})
     */
    public function listarPorProductoAction(Producto $producto, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:BitacoraSerial')
            ->findBy(array('producto' => $producto));

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaBodega/Producto/BitacoraSeriales/list_template.html.twig', array(
            'entities' => $entities,
            'producto' => $producto,
        ));
    }

    /**
     * Displays a form to edit an existing BitacoraSerial entity.
     *
     * @Route("/listarporbitacoraalmacen/{id}", name="bitacoraserial_listarpor_bitacoraalmacen", methods={"GET"}, options={"expose":true})
     */
    public function listarPorBitacoraAlmacenAction(BitacoraAlmacen $bitacoraalmacen, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:BitacoraSerial')
            ->findBy(
                array(
                    'tipoMovimiento' => $bitacoraalmacen->getTipoMovimiento(),
                    'movimientoLinea' => $bitacoraalmacen->getMovimientoLinea(),
                    'entradaSalidaLinea' => $bitacoraalmacen->getEntradaSalidaLinea(),
                    'produccionLinea' => $bitacoraalmacen->getProduccionLinea(),
                    'inventarioLinea' => $bitacoraalmacen->getInventarioLinea(),
                ));

        $entities = $this->get('knp_paginator')
            ->paginate(
                $entities,
                $request->query->get('page', 1),
                10
            );

        return $this->render('@BusetaBodega/BitacoraAlmacen/BitacoraSeriales/list_template.html.twig', array(
            'entities' => $entities,
            'bitacoraalmacen' => $bitacoraalmacen,
        ));
    }

}
