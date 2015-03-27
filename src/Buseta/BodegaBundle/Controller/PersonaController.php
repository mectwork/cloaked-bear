<?php

namespace Buseta\BodegaBundle\Controller;


use Buseta\BodegaBundle\Entity\Persona;
use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\BodegaBundle\Form\Model\PersonaModel;
use Buseta\BodegaBundle\Form\Type\PersonaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class PersonaController.
 *
 * @Route("/persona")
 */
class PersonaController extends Controller
{
    /**
     * @param Request $request
     * @internal $tercero
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/new/{tercero}", name="tercero_persona_new", methods={"GET"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function newAction(Request $request, Tercero $tercero)
    {
        if($tercero->getPersona() !== null) {
            $model = new PersonaModel($tercero->getPersona());
            $form = $this->createEditForm($model);
        } else {
            $model = new PersonaModel();
            $model->setTercero($tercero);
            $form = $this->createCreateForm($model);
        }

        return $this->render('@BusetaBodega/Persona/form_template.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Tercero entity.
     *
     * @param PersonaModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PersonaModel $entity)
    {
        $form = $this->createForm(new PersonaType(), $entity, array(
            'action' => $this->generateUrl('tercero_persona_create', array(
                'tercero' => $entity->getTercero()->getId()
            )),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a form to edit a Tercero entity.
     *
     * @param PersonaModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(PersonaModel $entity)
    {
        $form = $this->createForm(new PersonaType(), $entity, array(
            'action' => $this->generateUrl('tercero_persona_update', array(
                'id' => $entity->getId(),
                'tercero' => $entity->getTercero()->getId()
            )),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * @param Request $request
     * @internal $tercero
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/create/{tercero}", name="tercero_persona_create", methods={"POST"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function createAction(Request $request, Tercero $tercero)
    {
        $trans = $this->get('translator');

        $model = new PersonaModel();
        $model->setTercero($tercero);
        $form = $this->createCreateForm($model);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            try {
                if(!$model->isActivo()) {
                    $model = new PersonaModel();
                    $model->setTercero($tercero);

                    $form = $this->createCreateForm($model);
                    $renderView = $this->renderView('@BusetaBodega/Persona/form_template.html.twig', array(
                        'form'      => $form->createView(),
                    ));
                } else {
                    $persona = $model->getEntityData();

                    $em->persist($persona);
                    $em->flush();

                    $model = new PersonaModel($persona);
                    $form = $this->createEditForm($model);
                    $renderView = $this->renderView('@BusetaBodega/Persona/form_template.html.twig', array(
                        'form'      => $form->createView(),
                        'entity'    => $persona,
                    ));
                }

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.create.success', array(), 'BusetaBodegaBundle')
                ), 201);
            } catch (\Exception $e) {
                $error = $trans->trans('messages.create.error.%key%', array('key' => 'Persona'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf('%s. %s', $error, $e->getMessage()));

                $form->addError(new FormError($error));
            }
        }

        $view = $this->renderView('@BusetaBodega/Persona/form_template.html.twig', array(
            'form' => $form->createView(),
        ));

        return new JsonResponse(array(
            'view' => $view,
        ));
    }

    /**
     * @param Request $request
     * @param Persona $persona
     * @param Tercero $tercero
     * @internal $tercero
     * @return Response
     *
     * @Route("/{id}/update/{tercero}", name="tercero_persona_update", methods={"POST","PUT"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function updateAction(Request $request, Persona $persona, Tercero $tercero)
    {
        $trans      = $this->get('translator');

        $model = new PersonaModel($persona);
        $form = $this->createEditForm($model);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');

            try {
                if(!$model->isActivo()) {
                    $em->remove($persona);
                    $em->flush();

                    $model = new PersonaModel();
                    $model->setTercero($tercero);
                    $form = $this->createCreateForm($model);
                    $renderView = $this->renderView('@BusetaBodega/Persona/form_template.html.twig', array(
                        'form'      => $form->createView(),
                    ));
                } else {
                    $persona->setModelData($model);

                    $em->persist($persona);
                    $em->flush();

                    $model = new PersonaModel($persona);
                    $form = $this->createEditForm($model);
                    $renderView = $this->renderView('@BusetaBodega/Persona/form_template.html.twig', array(
                        'form'      => $form->createView(),
                        'entity'    => $persona,
                    ));
                }

                return new JsonResponse(array(
                    'view' => $renderView,
                    'message' => $trans->trans('messages.update.success', array(), 'BusetaBodegaBundle')
                ), 202);
            } catch (\Exception $e) {
                $error = $trans->trans('messages.update.error.%key%', array('key' => 'Persona'), 'BusetaBodegaBundle');
                $this->get('logger')->addCritical(sprintf('%s. %s', $error, $e->getMessage()));

                $form->addError(new FormError($error));
            }
        }

        $view = $this->renderView('@BusetaBodega/Persona/form_template.html.twig', array(
            'form' => $form->createView(),
        ));

        return new JsonResponse(array(
            'view' => $view,
        ));
    }

    /**
     * @param Request $request
     * @internal $tercero
     * @param Tercero $tercero
     * @return Response
     *
     * @Route("/{id}/edit/{tercero}", name="tercero_persona_edit", methods={"GET"}, options={"expose":true})
     * @ParamConverter("tercero", options={"mapping":{"tercero":"id"}})
     */
    public function editAction(Request $request, Persona $persona, Tercero $tercero)
    {
        $handler = $this->get('hatueyerp_terceros.persona.handler');
        $handler->bindData($tercero, $persona);

        return $this->render('@HatueyERPTerceros/Persona/form_template.html.twig', array(
            'form' => $handler->getForm()->createView(),
        ));
    }
}
