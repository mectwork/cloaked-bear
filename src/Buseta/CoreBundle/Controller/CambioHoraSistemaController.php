<?php

namespace Buseta\CoreBundle\Controller;

use Buseta\CoreBundle\Entity\CambioHoraSistema;
use Buseta\CoreBundle\Form\Type\CambioHoraSistemaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class CambioHoraSistemaController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cambioHoraConfig = $em->getRepository('CoreBundle:CambioHoraSistema')->findAll();
        if(count($cambioHoraConfig) == 1)
            $cambioHoraConfig = $cambioHoraConfig[0];
        elseif(count($cambioHoraConfig) == 0)
            $cambioHoraConfig = new CambioHoraSistema();
        else
            throw new \Exception('No pueden existir más de una configuración para cambio de hora en el sistema');

        $form = $this->createForm(new CambioHoraSistemaType(), $cambioHoraConfig);

        return $this->render('CoreBundle:CambioHoraSistema:index.html.twig',array(
                'form'      => $form->createView(),
                'entity'    => $cambioHoraConfig,
            ));
    }

    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $cambioHoraConfig = $em->getRepository('CoreBundle:CambioHoraSistema')->findAll();
        if(count($cambioHoraConfig) == 1)
            $cambioHoraConfig = $cambioHoraConfig[0];
        elseif(count($cambioHoraConfig) == 0)
            $cambioHoraConfig = new CambioHoraSistema();
        else
            throw new \Exception('No pueden existir más de una configuración para cambio de hora en el sistema');

        $form = $this->createForm(new CambioHoraSistemaType(), $cambioHoraConfig);

        $form->submit($request);
        if($form->isValid())
        {
            if($cambioHoraConfig->getActivo() && ($cambioHoraConfig->getHora() == null || $cambioHoraConfig->getHora() == ''))
            {
                $form->addError(new FormError('No puede establecer como activa la configuración de cambio de hora en el sistema sin seleccionar una hora válida'));
            }
            else
            {
                if($cambioHoraConfig->getActivo())
                {
                    $msg = sprintf('Se han salvado los cambios satisfactoriamente. El sistema establece el horario %s para el Servicio de Combustible',date_format($cambioHoraConfig->getHora(),'h:i a'));
                }
                else
                {
                    $cambioHoraConfig->setHora(null);
                    $msg = 'Se han salvado los cambios satisfactoriamente. El horario de cambio ahora se encuentra "Desactivado".';
                }

                //persisitiendo los datos
                $em->persist($cambioHoraConfig);
                $em->flush();

                $this->get('session')->getFlashBag()->set('success',$msg);

                return $this->redirect($this->generateUrl('cambiohora_index'));
            }
        }

        return $this->render('CoreBundle:CambioHoraSistema:index.html.twig',array(
                'form'      => $form->createView(),
                'entity'    => $cambioHoraConfig,
            ));
    }

}
