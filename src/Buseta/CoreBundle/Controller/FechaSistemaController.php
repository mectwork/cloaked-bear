<?php

namespace Buseta\CoreBundle\Controller;

use Buseta\CoreBundle\Entity\FechaSistema;
use Buseta\CoreBundle\Form\Type\FechaSistemaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class FechaSistemaController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fechaSistemaConfig = $em->getRepository('CoreBundle:FechaSistema')->findAll();
        if(count($fechaSistemaConfig) == 1)
            $fechaSistemaConfig = $fechaSistemaConfig[0];
        elseif(count($fechaSistemaConfig) == 0)
            $fechaSistemaConfig = new FechaSistema();
        else
            throw new \Exception('No pueden existir más de una configuración para fecha de sistema');

        $form = $this->createForm(new FechaSistemaType(),$fechaSistemaConfig);

        return $this->render('@Core/FechaSistema/index.html.twig',array(
                'form' => $form->createView(),
                'entity' => $fechaSistemaConfig,
            ));
    }

    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $fechaSistemaConfig = $em->getRepository('CoreBundle:FechaSistema')->findAll();
        if(count($fechaSistemaConfig) == 1)
            $fechaSistemaConfig = $fechaSistemaConfig[0];
        elseif(count($fechaSistemaConfig) == 0)
            $fechaSistemaConfig = new FechaSistema();
        else
            throw new \Exception('No pueden existir más de una configuración para fecha de sistema');

        $form = $this->createForm(new FechaSistemaType(), $fechaSistemaConfig);
        $form->submit($request);

        if($form->isValid()){

            if($fechaSistemaConfig->getActivo() && ($fechaSistemaConfig->getFecha() == null || $fechaSistemaConfig->getFecha() == ''))
            {
                $form->addError(new FormError('No puede establecer como activa la configuración de fecha del sistema sin seleccionar una fecha'));
            }
            else
            {
                if($fechaSistemaConfig->getActivo())
                {
                    $msg = 'Se han salvado los cambios satisfactoriamente. La fecha se encuentra "Activa".';
                }
                else
                {
                    $fechaSistemaConfig->setFecha(null);
                    $msg = 'Se han salvado los cambios satisfactoriamente. La fecha se encuentra "No activa".';
                }

                //persisitiendo los datos
                $em->persist($fechaSistemaConfig);
                $em->flush();

                $this->get('session')->getFlashBag()->set('success',$msg);

                return $this->redirect($this->generateUrl('fecha_sistema'));
            }
        }

        return $this->render('@Core/FechaSistema/index.html.twig',array(
                'form' => $form->createView(),
                'entity' => $fechaSistemaConfig,
            ));
    }

}
