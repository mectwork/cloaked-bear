<?php

namespace HatueySoft\SequenceBundle\Controller;

use HatueySoft\SequenceBundle\Entity\Sequence;
use HatueySoft\SequenceBundle\Form\Filter\SequenceFilter;
use HatueySoft\SequenceBundle\Form\Model\SequenceFilterModel;
use HatueySoft\SequenceBundle\Form\Type\SequenceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Sequence controller.
 *
 * @Route("/sequence")
 */
class SequenceController extends Controller
{
    /**
     * Lists all Sequence entities.
     */
    public function indexAction(Request $request)
    {
        //Obteniendo los valores definidos en el archivo "config.yml" para las secuencias
        $sequences_values = $this->get('service_container')->getParameter('hatuey_soft_sequence');
        $em = $this->get('doctrine.orm.entity_manager');

        //Recorrer arreglo bidimensional
        foreach($sequences_values as $name => $seq) {
            $sequence = new Sequence();

            $seq_existentes = $em
                ->getRepository('HatueySoftSequenceBundle:Sequence')->findBy(
                    array('name' => $name)
                );

            if(count($seq_existentes) == 0) {
                $sequence->setName($name);
                $sequence->setType('incremental');
                $sequence->setNumberIncrement(1);
                $sequence->setNumberNextInterval(1);
                $sequence->setPadding(0);

                $em->persist($sequence);
                $em->flush();
            }
        }

        $filter = new SequenceFilterModel();

        $form = $this->createForm(new SequenceFilter(), $filter, array(
            'action' => $this->generateUrl('sequence'),
        ));

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('HatueySoftSequenceBundle:Sequence')->filter($filter);
        } else {
            $entities = $this->get('doctrine.orm.entity_manager')
                ->getRepository('HatueySoftSequenceBundle:Sequence')->filter();
        }

        $paginator = $this->get('knp_paginator');
        $entities = $paginator->paginate(
            $entities,
            $request->query->get('page', 1),
            10
        );

        return $this->render('@HatueySoftSequence/Sequence/index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {
        $entity = new Sequence();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sequence_show', array('id' => $entity->getId())));
        }

        return $this->render('@HatueySoftSequence/Sequence/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Sequence entity.
     *
     * @param Sequence $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Sequence $entity)
    {
        $form = $this->createForm(new SequenceType(), $entity, array(
            'action' => $this->generateUrl('sequence_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Sequence entity.
     */
    public function newAction()
    {
        $entity = new Sequence();

        $form   = $this->createCreateForm($entity);

        return $this->render('HatueySoftSequenceBundle:Sequence:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Sequence entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSequenceBundle:Sequence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sequence entity.');
        }

        return $this->render('HatueySoftSequenceBundle:Sequence:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to edit an existing Sequence entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSequenceBundle:Sequence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sequence entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('@HatueySoftSequence/Sequence/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Sequence entity.
     *
     * @param Sequence $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Sequence $entity)
    {
        $form = $this->createForm(new SequenceType(), $entity, array(
            'action' => $this->generateUrl('sequence_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Sequence entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSequenceBundle:Sequence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Sequence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('sequence_show', array('id' => $id)));
        }

        return $this->render('@HatueySoftSequence/Sequence/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
