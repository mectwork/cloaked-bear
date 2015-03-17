<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 16/03/15
 * Time: 3:51
 */

namespace Buseta\TallerBundle\Form\EventListener;


use Doctrine\ORM\EntityRepository;
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
            FormEvents::SUBMIT => 'bind',
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
            $garantiaTarea = ($tarea) ? $tarea->getGarantia() : null;
            $this->addGarantiaTareaAdicionalForm($form, $tarea, $garantiaTarea);
        }
    }

    public function bind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === data) {
            return;
        }

        $tarea = array_key_exists('tarea', $data) ? $data['tarea'] : null;
        $garantiaTarea = array_key_exists('$garantiaTarea', $data) ? $data['$garantiaTarea'] : null;
        $this->addGarantiaTareaAdicionalForm($form, $tarea, $garantiaTarea);

    }

    private function addGarantiaTareaAdicionalForm(FormInterface $form, $tarea = null, $garantia = null)
    {
        if (null === $tarea) {
            $form->add('garantiaTarea', 'choice', array(
                'choices' => array(),
                'empty_value'   => '---Seleccione garantía---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('garantiaTarea', 'entity', array(
                'class' => 'BusetaNomencladorBundle:GarantiaTarea',
                'empty_value'   => '---Seleccione garantía---',
                'auto_initialize' => true,
                'data'          => $garantia,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($tarea) {
                    $qb = $repository->createQueryBuilder('garantia')
                        ->innerJoin('BusetaNomencladorBundle:Tarea', 'tarea');
                    if ($tarea instanceof Tarea) {
                        $qb->where('tarea = :tarea')
                            ->setParameter('tarea', $tarea);
                    } elseif (is_numeric($tarea)){
                        $qb->where('tarea.id = :id')
                            ->setParameter('id', $tarea);
                    } else {
                        $qb->where('tarea.valor = :valor')
                            ->setParameter('valor', $tarea);
                    }

                    return $qb;
                },
            ));
        }
    }
}