<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Form\Type\ObservacionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Buseta\TallerBundle\Entity\Reporte;
use Buseta\TallerBundle\Form\Type\ReporteType;
use Buseta\TallerBundle\Form\Model\ReporteFilterModel;
use Buseta\TallerBundle\Form\Filter\ReporteFilter;
use Symfony\Component\Security\Core\Util\ClassUtils;
use Buseta\TallerBundle\Event\FilterReporteEvent;
use Buseta\TallerBundle\Event\ReporteEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * Reporte controller.
 * @Route("/reporte")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo Estación de Servicios", routeName="taller_principal")
 */
class ReporteController extends Controller
{
    const DEFAULT_STATUS = 'BO';

    public function principalAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $resumentotalBO = $em->getRepository('BusetaTallerBundle:Reporte')->findTotalAtrasadas('BO');

        $resumentotalPR = $em->getRepository('BusetaTallerBundle:Reporte')->findTotalAtrasadas('PR');

        return $this->render('@BusetaTaller/Reporte/principal.html.twig', array(
            'resumentotalBO' => $resumentotalBO,
            'resumentotalPR' => $resumentotalPR
        ));
    }

    public function procesarReporteAction(Reporte $reporte)
    {
        //Se llama al EventDispatcher
        $eventDispatcher = $this->get('event_dispatcher');

        //Crear Eventos para el EventDispatcher
        $evento = new FilterReporteEvent($reporte);
        $evento->setReporte($reporte);

        //Lanzo los Evento donde se crea el diagnostico y
        //cambio el estado de la solicitud de Abierto a Pendiente

        $eventDispatcher->dispatch( ReporteEvents::PROCESAR_SOLICITUD, $evento );
        $eventDispatcher->dispatch( ReporteEvents::CAMBIAR_ESTADO_PENDIENTE, $evento );

        return $this->redirect($this->generateUrl('reporte_index'));
    }
    /**
     * Lists all Reporte entities.
     * @Route("/reporte", name="reporte")
     * @Breadcrumb(title="Solicitudes", routeName="reporte")
     */
    public function indexAction(Request $request)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS);
        $filter = new ReporteFilterModel();

        $form = $this->createForm(new ReporteFilter(), $filter, array(
            'action' => $this->generateUrl('reporte_index'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Reporte')->filter($status, $filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('BusetaTallerBundle:Reporte')->filter($status);
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        $em = $this->getDoctrine()->getManager();
        $resumentotal = $em->getRepository('BusetaTallerBundle:Reporte')->findTotalAtrasadasFilter($entities);

        return $this->render('BusetaTallerBundle:Reporte:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
            'status' => $status,
            'resumentotal' => $resumentotal
        ));
    }

    /**
     * Creates a new Reporte entity.
     *
     * @Security("is_granted('CREATE', 'Buseta\\TallerBundle\\Entity\\Reporte')")
     * @Breadcrumb(title="Crear Nuevo Usuario", routeName="security_usuario_create")
     */
    public function createAction(Request $request)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS );

        $entity = new Reporte();

        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            try {
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()
                    ->add('success', 'Se ha creado la Solicitud de forma satisfactoria.');

                return $this->redirect($this->generateUrl('reporte_show', array(
                    'id' => $entity->getId(),
                    'status' => $status,
                )));
            } catch(\Exception $e) {
                $this->get('logger')
                    ->addCritical(sprintf('Ha ocurrido un error creando la Solicitud. Detalles: %s', $e->getMessage()));

                $this->get('session')->getFlashBag()
                    ->add('danger', 'Ha ocurrido un error creando la Solicitud.');
            }
        }

        return $this->render('BusetaTallerBundle:Reporte:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'status' => $status,
        ));
    }

    /**
     * Creates a form to create a Reporte entity.
     *
     * @param Reporte $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Reporte $entity)
    {
        $form = $this->createForm(new ReporteType(), $entity, array(
            'action' => $this->generateUrl('reporte_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Reporte entity.
     *
     * @Security("is_granted('CREATE', 'Buseta\\TallerBundle\\Entity\\Reporte')")
     * @Route("/new", name="reporte_new")
     * @Breadcrumb(title="Crear Nueva Solicitud", routeName="reporte_new")
     */
    public function newAction(Request $request)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS );
        $sequenceManager = $this->get('hatuey_soft.sequence.manager');
        $entity = new Reporte();

        if ($sequenceManager->hasSequence(ClassUtils::getRealClass($entity))) {
            $entity->setNumero($sequenceManager->getNextValue('reporte_seq'));
        }

        $observacion = $this->createForm(new ObservacionType());

        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaTallerBundle:Reporte:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'observacion'  => $observacion->createView(),
            'status' => $status,
        ));
    }

    /**
     * Finds and displays a Reporte entity.
     *
     * @Security("is_granted('VIEW', reporte)")
     * @Route("/{id}/show", name="reporte_show")
     * @Breadcrumb(title="Ver Datos de Solicitud", routeName="reporte_show", routeParameters={"id"})
     */
    public function showAction(Request $request, Reporte $reporte)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS);
        $deleteForm = $this->createDeleteForm($reporte->getId());

        return $this->render('BusetaTallerBundle:Reporte:show.html.twig', array(
            'entity' => $reporte,
            'id' => $reporte->getId(),
            'delete_form' => $deleteForm->createView(),
            'status' => $status,
        ));
    }

    /**
     * Creates a form to delete a Reporte entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reporte_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}
