<?php

namespace HatueySoft\SecurityBundle\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HatueySoft\SecurityBundle\Entity\User as Usuario;
use HatueySoft\SecurityBundle\Form\Type\UsuarioType as UsuarioType;

/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="security_usuario")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HatueySoftSecurityBundle:User')->findAll();

        return $this->render('HatueySoftSecurityBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/create", name="security_usuario_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager    = $this->get('fos_user.user_manager');
            $userManager->updateUser($entity);

            return $this->redirect($this->generateUrl('security_usuario_show', array('id' => $entity->getId())));
        }

        return $this->render('HatueySoftSecurityBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm('hatueysoft_security_usuario_type', $entity, array(
            'action' => $this->generateUrl('security_usuario_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="security_usuario_new")
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return $this->render('HatueySoftSecurityBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}/show", name="security_usuario_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSecurityBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HatueySoftSecurityBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/{id}/edit", name="security_usuario_edit")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSecurityBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HatueySoftSecurityBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm('hatueysoft_security_usuario_type', $entity, array(
            'action' => $this->generateUrl('security_usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}/update", name="security_usuario_update")
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HatueySoftSecurityBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('security_usuario_edit', array('id' => $id)));
        }

        return $this->render('HatueySoftSecurityBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Usuario entity.
     *
     * @Route("/{id}/delete", name="security_usuario_delete")
     * @Method({"POST", "DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HatueySoftSecurityBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('security_usuario'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('security_usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
