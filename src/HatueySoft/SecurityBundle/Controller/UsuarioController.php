<?php

namespace HatueySoft\SecurityBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use HatueySoft\SecurityBundle\Form\Model\UserModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use HatueySoft\SecurityBundle\Entity\User as Usuario;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

/**
 * Usuario controller.
 *
 * @Route("/usuario")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo Seguridad", routeName="security_usuario")
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="security_usuario")
     * @Breadcrumb(title="Listado de Usuarios", routeName="security_usuario")
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
     * @Breadcrumb(title="Crear Nuevo Usuario", routeName="security_usuario_create")
     */
    public function createAction(Request $request)
    {
        $model = new UserModel();
        $form = $this->createCreateForm($model);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = new Usuario();

            $user->setUsername($model->getUsername());
            $user->setEmail($model->getEmail());
            $user->setNombres($model->getNombres());
            $user->setApellidos($model->getApellidos());
            $user->setRoles($model->getRoles());
            $user->setPlainPassword($model->getPlainPassword());

            $gruposBuses = new ArrayCollection();
            foreach ($model->getGrupobuses() as $group) {
                $gruposBuses->add($group);
            }
            $user->setGrupoBuses($gruposBuses);

            if (0 !== strlen($model->getPin())) {
                $user->setPin($model->getPin());
            }

            $userManager    = $this->get('fos_user.user_manager');

            try {
                $this->get('session')->getFlashBag()->add('success', 'Se ha creado el usuario satisfactoriamente.');

                $userManager->updateUser($user);

                return $this->redirect($this->generateUrl('security_usuario_show', array('id' => $user->getId())));
            } catch (\Exception $e) {
                $this->get('logger')->critical(sprintf('Ha ocurrido un error al crear el usuario. Detalles: %s', $e->getMessage()));
                $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al crear el usuario.');
            }
        }

        return $this->render('HatueySoftSecurityBundle:Usuario:new.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $model The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UserModel $model = null)
    {
        $form = $this->createForm('hatueysoft_security_usuario_type', $model, array(
            'action' => $this->generateUrl('security_usuario_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     * @Route("/new", name="security_usuario_new")
     * @Breadcrumb(title="Crear Nuevo Usuario", routeName="security_usuario_create")
     */
    public function newAction()
    {
        $form   = $this->createCreateForm(new UserModel());

        return $this->render('HatueySoftSecurityBundle:Usuario:new.html.twig', array(
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/{id}/show", name="security_usuario_show")
     * @Breadcrumb(title="Ver Datos de Usuario", routeName="security_usuario_show", routeParameters={"id"})
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
     * @param Usuario $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="security_usuario_edit")
     * @Breadcrumb(title="Modificar Usuario", routeName="security_usuario_edit", routeParameters={"id"})
     */
    public function editAction(Usuario $user)
    {
        $editForm = $this->createEditForm(new UserModel($user));
        $deleteForm = $this->createDeleteForm($user->getId());

        return $this->render('HatueySoftSecurityBundle:Usuario:edit.html.twig', array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param UserModel $model The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UserModel $model)
    {
        $form = $this->createForm('hatueysoft_security_usuario_type', $model, array(
            'action' => $this->generateUrl('security_usuario_update', array('id' => $model->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     * @Route("/{id}/update", name="security_usuario_update")
     * @Method({"POST", "PUT"})
     * @Breadcrumb(title="Modificar Usuario", routeName="security_usuario_edit", routeParameters={"id"})
     */
    public function updateAction(Request $request, Usuario $user)
    {
        $model = new UserModel($user);
        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($model);

        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $userManager = $this->get('fos_user.user_manager');

            $user->setNombres($model->getNombres());
            $user->setApellidos($model->getApellidos());
            $user->setEmail($model->getEmail());
            $user->setRoles($model->getRoles());

            $gruposBuses = new ArrayCollection();
            foreach ($model->getGrupobuses() as $group) {
                $gruposBuses->add($group);
            }
            $user->setGrupoBuses($gruposBuses);

            if (0 !== strlen($model->getPlainPassword())) {
                $user->setPlainPassword($model->getPlainPassword());
                $userManager->updatePassword($user);
            }

            if (0 !== strlen($model->getPin())) {
                $user->setPin($model->getPin());
            }

            try {
                $userManager->updateUser($user);

                $this->get('session')->getFlashBag()->add('success', 'Se han editado los datos del usuario satisfactoriamente.');

                return $this->redirect($this->generateUrl('security_usuario_edit', array('id' => $user->getId())));
            } catch (\Exception $e) {
                $this->get('logger')->critical(sprintf('Ha ocurrido un error al editar los datos del usuario. Detalles: %s', $e->getMessage()));
                $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al editar los datos del usuario.');
            }
        }

        return $this->render('HatueySoftSecurityBundle:Usuario:edit.html.twig', array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
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
