<?php

namespace Buseta\BodegaBundle\Controller;

use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BodegaBundle\Form\Filter\BitacoraAlmacenFilter;
use Buseta\BodegaBundle\Form\Model\BitacoraAlmacenFilterModel;
use Buseta\BodegaBundle\Form\Model\BitacoraAlmacenModel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\BodegaBundle\Entity\BitacoraSerial;
use Buseta\BodegaBundle\Form\Type\BitacoraAlmacenType;
use Buseta\BodegaBundle\Extras\FuncionesExtras;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * BitacoraSerial controller.
 *
 *
 */
class BitacoraSerialController extends Controller
{


    /**
     * Lists all BitacoraSerial entities.
     */
/*    public function indexAction(Request $request)
    {
        $filter = new BitacoraAlmacenFilterModel();

        $form = $this->createForm(new BitacoraAlmacenFilter(), $filter, array(
            'action' => $this->generateUrl('bitacoraalmacen'),
        ));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('BusetaBodegaBundle:BitacoraAlmacen:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }*/



    /**
     * Finds and displays a BitacoraAlmacen entity.
     */
/*    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BitacoraAlmacen entity.');
        }

        return $this->render('BusetaBodegaBundle:BitacoraAlmacen:show.html.twig', array(
            'entity'      => $entity
              ));
    }*/

    //A partir de aqui el metodo requerido para el AJAX que llama desde el formulario de Producto
    /**
     * @param Producto $producto
     * @return Response
     */
    public function listAction(Producto $producto, Request $request)
    {
        $entities = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaBodegaBundle:BitacoraSerial')
            ->findBy(array('producto' => $producto) );

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


}
