<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 16/03/15
 * Time: 3:51.
 */

namespace Buseta\TallerBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class AddGarantiaTareaAdicionalFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'bind',
        );
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null == $data) {
            $this->addGarantiaTareaAdicionalForm($form);
        } else {
            $tarea = ($data->getTarea()) ? $data->getTarea() : null;
            $this->addGarantiaTareaAdicionalForm($form, $tarea);
        }
    }

    public function bind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $tarea = array_key_exists('tarea', $data) ? $data['tarea'] : null;
        $this->addGarantiaTareaAdicionalForm($form, $tarea);
    }

    private function addGarantiaTareaAdicionalForm(FormInterface $form, $tarea = null)
    {
        if (null === $tarea) {
            $form->add('garantiaTarea', 'number', array(
                'required' => true,
                'read_only' => true,
                'label' => 'Garantía tarea',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('garantiaTarea', 'number', array(
                'required' => true,
                'label' => 'Garantía tarea',
                'read_only' => true,
                'data' => $tarea->getGarantia()->getDias(),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        }
    }
}
