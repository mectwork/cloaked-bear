<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\Diagnostico;
use Buseta\TallerBundle\Entity\Observacion;
use Buseta\TallerBundle\Entity\ObservacionDiagnostico;
use Buseta\TallerBundle\Form\Type\ObservacionDiagnosticoType;
use Buseta\TallerBundle\Form\Type\ObservacionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\TallerBundle\Form\Type\DiagnosticoType;
use Buseta\TallerBundle\Form\Model\DiagnosticoFilterModel;
use Buseta\TallerBundle\Form\Filter\DiagnosticoFilter;

/**
 * Diagnostico controller.
 *
 */
class DiagnosticoController extends Controller
{

    /**
     * Lists all Diagnostico entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new DiagnosticoFilterModel();

        $form = $this->createForm(new DiagnosticoFilter(), $filter, array(
            'action' => $this->generateUrl('diagnostico'),
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Diagnostico')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Diagnostico')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );


        return $this->render('BusetaTallerBundle:Diagnostico:index.html.twig', array(
            'entities' => $entities,
            'filter_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Diagnostico entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Diagnostico')->find($id);

        $reportes = $em->getRepository('BusetaTallerBundle:Reporte')->find($entity->getReporte()->getId());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Diagnostico entity.');
        }

        return $this->render('BusetaTallerBundle:Diagnostico:show.html.twig', array(
            'entity' => $entity,
            'reportes' => $reportes,
            'id' => $id
        ));
    }
}
