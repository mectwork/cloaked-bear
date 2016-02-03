<?php

namespace Buseta\CombustibleBundle\Controller;

use Buseta\CombustibleBundle\Entity\ConfiguracionCombustible;
use Buseta\CombustibleBundle\Form\Type\ConfiguracionCombustibleType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * ConfiguracionCombustible controller.
 *
 * @Route("/configuracion/combustible")
 */
class ConfiguracionCombustibleController extends Controller
{
    /**
     * Lists all ConfiguracionCombustible entities.
     *
     * @Route("/", name="configuracion_combustible")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('BusetaCombustibleBundle:ConfiguracionCombustible')->findAll();

        return $this->render('BusetaCombustibleBundle:ConfiguracionCombustible:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to create a new ConfiguracionCombustible entity.
     *
     * @Route("/new", name="configuracion_combustible_new", methods={"GET"}, options={"expose":true})
     */
    public function newAction()
    {
        $entity = new ConfiguracionCombustible();
        $form   = $this->createCreateForm($entity);

        return $this->render('BusetaCombustibleBundle:ConfiguracionCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ConfiguracionCombustible entity.
     *
     * @param ConfiguracionCombustible $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ConfiguracionCombustible $entity)
    {
        $form = $this->createForm('combustible_configuracion_combustible', $entity, array(
            'action' => $this->generateUrl('configuracion_combustible_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a new ConfiguracionCombustible entity.
     *
     * @Route("/create", name="configuracion_combustible_create", methods={"POST"}, options={"expose":true})
     */
    public function createAction(Request $request)
    {
        $entity = new ConfiguracionCombustible();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('configuracion_combustible_show', array('id' => $entity->getId())));
        }

        return $this->render('BusetaCombustibleBundle:ConfiguracionCombustible:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ConfiguracionCombustible entity.
     *
     * @Route("/{id}/show", name="configuracion_combustible_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ConfiguracionCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ConfiguracionCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaCombustibleBundle:ConfiguracionCombustible:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ConfiguracionCombustible entity.
     *
     * @Route("/{id}/delete", name="configuracion_combustible_delete", options={"expose": true})
     * @Method({"DELETE", "GET", "POST"})
     */
    public function deleteAction(ConfiguracionCombustible $configuracionCombustible, Request $request)
    {
        $trans = $this->get('translator');
        $deleteForm = $this->createDeleteForm($configuracionCombustible->getId());

        $deleteForm->handleRequest($request);
        if($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            try {
                $em = $this->get('doctrine.orm.entity_manager');

                $em->remove($configuracionCombustible);
                $em->flush();

                $message = $trans->trans('messages.delete.success', array(), 'BusetaCombustibleBundle');

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 202);
                }
                else {
                    $this->get('session')->getFlashBag()->add('success', $message);
                }
            } catch (\Exception $e) {
                $message = $trans->trans('messages.delete.error.%key%', array('key' => 'ConfiguracionCombustible'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf($message.' Detalles: %s', $e->getMessage()));

                if($request->isXmlHttpRequest()) {
                    return new JsonResponse(array(
                        'message' => $message,
                    ), 500);
                }
            }
        }

        $renderView =  $this->renderView('@BusetaCombustible/ConfiguracionCombustible/delete_modal.html.twig', array(
            'entity' => $configuracionCombustible,
            'form' => $deleteForm->createView(),
        ));

        if($request->isXmlHttpRequest()) {
            return new JsonResponse(array('view' => $renderView));
        }
        return $this->redirect($this->generateUrl('configuracion_combustible'));
    }

    /**
     * Creates a form to delete a ConfiguracionCombustible entity by id.
     *
     * @param mixed $id The entity id
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configuracion_combustible_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     *
     * @Route("/obtener_producto_de_bodega", name="obtener_producto_de_bodega", options={"expose": true})
     * @Method({"GET"})
     */
    public function obtenerProductoBodegaAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new \Symfony\Component\HttpFoundation\Response('Acceso Denegado', 403);
        }

        if (!$request->isXmlHttpRequest()) {
            return new \Symfony\Component\HttpFoundation\Response('No es una petición Ajax', 500);
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $bitacoras = $em->getRepository('BusetaBodegaBundle:BitacoraAlmacen')->findAll();

        $json = array();
        foreach ($bitacoras as $bitacora) {
            if ($bitacora->getAlmacen()->getId() == $request->query->get('bodega_id')) {
                $json[] = array(
                    'id' => $bitacora->getProducto()->getId(),
                    'valor' => $bitacora->getProducto()->getNombre(),
                );
            }
        }

        return new \Symfony\Component\HttpFoundation\Response(json_encode($json), 200);
    }

    /**
     * Displays a form to edit an existing Tercero entity.
     *
     * @param ConfiguracionCombustible $configuracionCombustible
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/{id}/edit", name="configuracion_combustible_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ConfiguracionCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ConfiguracionCombustible entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BusetaCombustibleBundle:ConfiguracionCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Autobus entity.
     *
     * @param ConfiguracionCombustible $configuracionCombustible The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(ConfiguracionCombustible $entity)
    {
        $form = $this->createForm(new ConfiguracionCombustibleType(), $entity, array(
            'action' => $this->generateUrl('configuracion_combustible_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing ConfiguracionCombustible entity.
     *
     * @Route("/{id}/update", name="configuracion_combustible_update", options={"expose": true})
     * @Method({"POST", "PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BusetaCombustibleBundle:ConfiguracionCombustible')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ConfiguracionCombustible entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('configuracion_combustible_show', array('id' => $id)));
        }

        return $this->render('BusetaCombustibleBundle:ConfiguracionCombustible:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
