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
        //Obteniendo los valores definidos en el archivo "config.yml" para las secuencias
        $sequences_values = $this->get('service_container')->getParameter('hatuey_soft_sequence');
        $em = $this->get('doctrine.orm.entity_manager');

        //Recorrer arreglo bidimensional
        foreach($sequences_values as $nombre=>$seq) {
            $secuencia = new Secuencia();

            $sec_existentes = $em
                ->getRepository('HatueySoftSequenceBundle:Secuencia')->findBy(
                    array('nombre' => $nombre)
                );

            if(count($sec_existentes) == 0) {
                $secuencia->setNombre($nombre);

                $em->persist($secuencia);
                $em->flush();
            }
        }

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
            10
        );

        return $this->render('@HatueySoftSequence/Secuencia/index.html.twig', array(
            'entities'      => $entities,
            'filter_form'   => $form->createView(),
        ));
    }

    public function createAction(Request $request)
    {
        $entity = new Secuencia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secuencia_show', array('id' => $entity->getId())));
        }

        return $this->render('@HatueySoftSequence/Secuencia/new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
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

    /**
     * Finds and displays a Secuencia entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSequenceBundle:Secuencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secuencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HatueySoftSequenceBundle:Secuencia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Secuencia entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSequenceBundle:Secuencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secuencia entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('@HatueySoftSequence/Secuencia/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Secuencia entity.
     *
     * @param Secuencia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Secuencia $entity)
    {
        $form = $this->createForm(new SecuenciaType(), $entity, array(
            'action' => $this->generateUrl('secuencia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Secuencia entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSequenceBundle:Secuencia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secuencia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('secuencia_show', array('id' => $id)));
        }

        return $this->render('@HatueySoftSequence/Secuencia/edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Secuencia entity.
     *
     * @Route("/{id}/delete", name="secuencia_delete")
     * @Method({"DELETE", "GET"})
     */
    public function deleteAction(Secuencia $secuencia, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($secuencia->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($secuencia);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaTallerBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'Secuencia'), 'BusetaTallerBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@HatueySoftSequence/Secuencia/delete_modal.html.twig', array(
            'entity' => $secuencia,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('secuencia'));
    }

    /**
     * Creates a form to delete a Secuencia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('secuencia_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

?>
