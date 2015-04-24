<?php

namespace HatueySoft\SequenceBundle\Controller;

use HatueySoft\SequenceBundle\Entity\Secuencia;
use HatueySoft\SequenceBundle\Form\Filter\SecuenciaFilter;
use HatueySoft\SequenceBundle\Form\Model\SecuenciaFilterModel;
use HatueySoft\SequenceBundle\Form\Type\SecuenciaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Secuencia controller.
 *
 * @Route("/secuencia")
 */
class SecuenciaController extends Controller
{
    /**
     * Lists all Secuencia entities.
     */
    public function indexAction(Request $request)
    {
        $filter = new SecuenciaFilterModel();

        $form = $this->createForm(new SecuenciaFilter(), $filter, array(
            'action' => $this->generateUrl('secuencia'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('HatueySoftSequenceBundle:Secuencia')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('HatueySoftSequenceBundle:Secuencia')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            5
        );

        return $this->render('@HatueySoftSequence/Secuencia/index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Secuencia entity.
     *
     * @Route("/create", name="secuencias_secuencia_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $secuencia = new Secuencia();
        $form = $this->createCreateForm($secuencia);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em     = $this->get('doctrine.orm.entity_manager');
            $trans  = $this->get('translator');
            $logger = $this->get('logger');

            try {
                //$entity = $secuencia->getEntityData();

                $em->persist($secuencia);
                $em->flush();

                // Creando nuevamente el formulario con los datos actualizados de la entidad
                //$form = $this->createEditForm(new Secuencia($secuencia));
                $renderView = $this->renderView('@HatueySoftSequence/Secuencia/form_template.html.twig', array(
                    'form'   => $form->createView(),
                ));

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
                ), 201);
            } catch (\Exception $e) {
                $logger->addCritical(sprintf(
                    $trans->trans('', array(), 'BusetaBodegaBundle') . '. Detalles: %s',
                    $e->getMessage()
                ));

                return new JsonResponse(array(
                    'message' => $trans->trans('messages.create.error.%key%', array('key' => 'Secuencia'), 'BusetaBodegaBundle')
                ), 500);
            }
        }

        $renderView = $this->renderView('@HatueySoftSequence/Secuencia/form_template.html.twig', array(
            'form'     => $form->createView(),
        ));

        return new JsonResponse(array('view' => $renderView));
    }

    /**
     * Creates a form to create a Secuencia entity.
     *
     * @param Secuencia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Secuencia $entity)
    {
        $form = $this->createForm(new SecuenciaType(), $entity, array(
            'action' => $this->generateUrl('secuencia_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Secuencia entity.
     */
    public function newAction()
    {
        $entity = new Secuencia();

        $form   = $this->createCreateForm($entity);

        return $this->render('HatueySoftSequenceBundle:Secuencia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}

?>