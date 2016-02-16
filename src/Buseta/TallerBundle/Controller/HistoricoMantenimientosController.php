<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Form\Filter\HistoricoMantenimientosFilter;
use Buseta\TallerBundle\Form\Model\HistoricoMantenimientosFilterModel;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
/**
 * HistoricoMantenimientos controller.
 *
 * @Route("/historicom")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Taller", routeName="taller_principal")
 */
class HistoricoMantenimientosController extends Controller
{
    /**
     * Lists all HistoricoMantenimientos entities.
     *
     * @Route("/", name="historicomantenimientos", methods={"GET"})
     * @Breadcrumb(title="Histórico de Mantenimientos", routeName="historicomantenimientos")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $filter = new HistoricoMantenimientosFilterModel();

        $form = $this->createForm(new HistoricoMantenimientosFilter(), $filter, array(
                'action' => $this->generateUrl('historicomantenimientos'),
            ));

        $repository = $em->getRepository('BusetaTallerBundle:TareaAdicional');
        $qb = $repository->createQueryBuilder('dta');

        $query = $qb->addSelect('dot')
            ->innerJoin('dta.ordenTrabajo', 'dot');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($filter->getAutobus() !== null && $filter->getAutobus() !== '') {
                $query->innerJoin('dot.autobus', 'da')
                    ->andWhere($qb->expr()->like('da.matricula', ':autobus'))
                    ->setParameter('autobus', '%'.$filter->getAutobus().'%');
            }
            if ($filter->getGrupo() !== null && $filter->getGrupo() !== '') {
                $query->innerJoin('dta.grupo', 'ng')
                    ->andWhere($qb->expr()->like('ng.valor', ':grupo'))
                    ->setParameter('grupo', '%'.$filter->getGrupo().'%');
            }
            if ($filter->getSubgrupo() !== null && $filter->getSubgrupo() !== '') {
                $query->innerJoin('dta.subgrupo', 'nsg')
                    ->andWhere($qb->expr()->like('nsg.valor', ':subgrupo'))
                    ->setParameter('subgrupo', '%'.$filter->getSubgrupo().'%');
            }
            if ($filter->getTarea() !== null && $filter->getTarea() !== '') {
                $query->innerJoin('dta.tareamantenimiento', 'tm')
                    ->innerJoin('tm.valor', 'tarea')
                    ->andWhere($qb->expr()->like('tarea.valor', ':tarea'))
                    ->setParameter('tarea', '%'.$filter->getTarea().'%');
            }
        }

        try {
            $entities = $query->getQuery();
        } catch (NoResultException $e) {
            $entities = array();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1),
            10,
            array('pageParameterName' => 'page')
        );

        return $this->render('BusetaTallerBundle:HistoricoMantenimientos:index.html.twig', array(
                'entities' => $entities,
                'filter_form' => $form->createView(),
            ));
    }
}
