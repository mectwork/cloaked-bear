<?php

namespace Buseta\TallerBundle\Controller;

use Buseta\TallerBundle\Entity\Diagnostico;
use Buseta\TallerBundle\Entity\Observacion;
use Buseta\TallerBundle\Entity\ObservacionDiagnostico;
use Buseta\TallerBundle\Form\Type\ObservacionReporteType;
use Buseta\TallerBundle\Form\Type\ObservacionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Buseta\TallerBundle\Entity\Reporte;
use Buseta\TallerBundle\Form\Type\ReporteType;
use Buseta\TallerBundle\Form\Model\ReporteFilterModel;
use Buseta\TallerBundle\Form\Filter\ReporteFilter;

/**
 * Reporte controller.
 *
 */
class ReporteController extends Controller
{
    const DEFAULT_STATUS = 'BO';

    public function principalAction()
    {
        return $this->render('@BusetaTaller/Reporte/principal.html.twig');
    }

    public function procesarReporteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $reporte = $em->getRepository('BusetaTallerBundle:Reporte')->find($id);

        if (!$reporte) {
            throw $this->createNotFoundException('Unable to find Reporte entity.');
        }

        //Cambia el estado de Borrador a Procesado
        $reporte->setEstado('PR');
        $em->persist($reporte);
        $em->flush();

        return $this->redirect($this->generateUrl('reporte'));
    }

    public function generarDiagnosticoAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $reporte = $em->getRepository('BusetaTallerBundle:Reporte')->find($id);

        if (!$reporte) {
            throw $this->createNotFoundException('Unable to find Reporte entity.');
        }

        //Crear nuevo Diagnostico a partir del Reporte seleccionado
        $diagnostico = new Diagnostico();
        $diagnostico->setNumero($reporte->getNumero());
        $diagnostico->setReporte($reporte);
        $diagnostico->setAutobus($reporte->getAutobus());
        $em->persist($diagnostico);

        $reporte->setEstado('CO');
        $em->persist($reporte);

        $em->flush();

        return $this->redirect($this->generateUrl('reporte'));
    }

    /**
     * Lists all Reporte entities.
     */
    public function indexAction(Request $request)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS);
        $filter = new ReporteFilterModel();

        $form = $this->createForm(new ReporteFilter(), $filter, array(
            'action' => $this->generateUrl('reporte'),
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

        return $this->render('BusetaTallerBundle:Reporte:index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
            'status' => $status
        ));
    }

    /**
     * Creates a new Reporte entity.
     *
     */
    public function createAction(Request $request)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS);

        $entity = new Reporte();
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            try {
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()
                    ->add('success', 'Se ha creado el Reporte de forma satisfactoria.');

                return $this->redirect($this->generateUrl('reporte_show', array(
                    'id' => $entity->getId(),
                    'status' => $status,
                )));
            } catch(\Exception $e) {
                $this->get('logger')
                    ->addCritical(sprintf('Ha ocurrido un error creando el Reporte. Detalles: %s', $e->getMessage()));

                $this->get('session')->getFlashBag()
                    ->add('danger', 'Ha ocurrido un error creando el Reporte.');
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
     */
    public function newAction(Request $request)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS);
        $entity = new Reporte();

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
     */
    public function showAction(Request $request, $id)
    {
        $status = $request->query->get('status', self::DEFAULT_STATUS);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaTallerBundle:Reporte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reporte entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaTallerBundle:Reporte:show.html.twig', array(
            'entity'      => $entity,
            'id' => $id,
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
