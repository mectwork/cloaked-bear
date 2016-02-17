<?php

namespace Buseta\CombustibleBundle\Controller;


use Buseta\CombustibleBundle\Entity\ConfiguracionMarchamo;
use Buseta\CombustibleBundle\Form\Model\ConfiguracionMarchamoModel;
use Buseta\CombustibleBundle\Form\Type\ConfiguracionMarchamoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

/**
 * Class ConfiguracionMarchamoController
 * @package Buseta\CombustibleBundle\Controller
 *
 * @Route("/configuracion/marchamo")
 * @Breadcrumb(title="Inicio", routeName="core_homepage")
 * @Breadcrumb(title="Módulo de Combustible", routeName="servicioCombustible")
 * * @Breadcrumb(title="Modificar Datos de la Configuración de Marchamo")
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
        $em = $this->get('doctrine.orm.entity_manager');
        $conf = $em->getRepository('BusetaCombustibleBundle:ConfiguracionMarchamo')
            ->getActiveConfiguration();
        $conf = $conf ? $conf : new ConfiguracionMarchamo();

        $model = new ConfiguracionMarchamoModel($conf);
        $form = $this->createEditForm($model);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $conf->setBodega($model->getBodega());
            $conf->setProducto($model->getProducto());

            try {
                $em->persist($conf);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Se han salvado los datos de forma satisfactoria.');

                return $this->redirect($this->generateUrl('combustible_configuracion_marchamo'));
            } catch (\Excepcion $e) {
                $this->get('logger')->critical('Ha ocurrido un error al salvar los datos para Configuración de Marhamo. Detalles: %s', $e->getMessage());
                $this->get('session')->getFlashBag()->add('danger', 'Ha ocurrido un error al salvar los datos para Configuración de Marhamo.');
            }
        }

        return $this->render('@BusetaCombustible/ConfiguracionMarchamo/edit.html.twig', array(
            'form' => $form,
        ));
    }
}
