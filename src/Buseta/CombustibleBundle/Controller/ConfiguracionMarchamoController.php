<?php

namespace Buseta\CombustibleBundle\Controller;


use Buseta\CombustibleBundle\Form\Model\ConfiguracionMarchamoModel;
use Buseta\CombustibleBundle\Form\Type\ConfiguracionMarchamoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ConfiguracionMarchamoController
 * @package Buseta\CombustibleBundle\Controller
 *
 * @Route("/configuracion/marchamo")
 */
class ConfiguracionMarchamoController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="combustible_configuracion_marchamo")
     * @Method("GET")
     */
    public function editAction(Request $request)
    {
        $conf = $this->get('doctrine.orm.entity_manager')
            ->getRepository('BusetaCombustibleBundle:ConfiguracionMarchamo')
            ->getActiveConfiguration();

        $model = new ConfiguracionMarchamoModel($conf);
        $form = $this->createEditForm($model);

        return $this->render('@BusetaCombustible/ConfiguracionMarchamo/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function createEditForm(ConfiguracionMarchamoModel $model = null)
    {
        $form = $this->createForm(new ConfiguracionMarchamoType(), $model, array(
            'action' => $this->generateUrl('combustible_configuracion_marchamo_update'),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/update", name="combustible_configuracion_marchamo_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request)
    {
        return array();
    }
}
