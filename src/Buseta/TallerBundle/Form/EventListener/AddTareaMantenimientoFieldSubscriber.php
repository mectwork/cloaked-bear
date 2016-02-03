<?php

namespace Buseta\TallerBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\NomencladorBundle\Entity\Subgrupo;

class AddTareaMantenimientoFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT     => 'preBind',
        );
    }

    private function addTareaMantenimientoForm($form, $tareamantenimiento = null, $subgrupo = null)
    {
        if ($subgrupo === null) {
            $form->add('tareamantenimiento', 'choice', array(
                'choices' => array(),
                'placeholder'   => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('tareamantenimiento', 'entity', array(
                'class'         => 'BusetaTallerBundle:TareaMantenimiento',
                'placeholder'   => '---Seleccione---',
                'auto_initialize' => false,
                'data'          => $tareamantenimiento,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($subgrupo) {
                        $qb = $repository->createQueryBuilder('tareamantenimiento')
                            ->innerJoin('tareamantenimiento.subgrupo', 'subgrupo');
                        if ($subgrupo instanceof Subgrupo) {
                            $qb->where('subgrupo = :subgrupo')
                                ->setParameter('subgrupo', $subgrupo);
                        } elseif (is_numeric($subgrupo)) {
                            $qb->where('subgrupo.id = :subgrupo')
                                ->setParameter('subgrupo', $subgrupo);
                        } else {
                            $qb->where('subgrupo.valor = :subgrupo')
                                ->setParameter('subgrupo', null);
                        }

                        return $qb;
                    },
            ));
        }
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null == $data) {
            $this->addTareaMantenimientoForm($form);
        } else {
            $tareamantenimiento = ($data->getTareaMantenimiento()) ? $data->getTareaMantenimiento() : null;
            $subgrupo = ($tareamantenimiento) ? $tareamantenimiento->getSubgrupo() : null;
            $this->addTareaMantenimientoForm($form, $tareamantenimiento, $subgrupo);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $tareamantenimiento = array_key_exists('tareamantenimiento', $data) ? $data['tareamantenimiento'] : null;
        $subgrupo = array_key_exists('subgrupo', $data) ? $data['subgrupo'] : null;
        $this->addTareaMantenimientoForm($form, $tareamantenimiento, $subgrupo);
    }
}
