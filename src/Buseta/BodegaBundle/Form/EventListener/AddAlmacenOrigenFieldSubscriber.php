<?php

namespace Buseta\BodegaBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddAlmacenOrigenFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA    => 'preSetData',
            FormEvents::PRE_SUBMIT      => 'preBind',
        );
    }

    private function addAlmacenOrigenForm($form, $almacenOrigen = null)
    {
        $form->add('almacenOrigen', 'entity', array(
            'class'         => 'BusetaBodegaBundle:Bodega',
            'auto_initialize' => false,
            'empty_value'   => '---Seleccione---',
            'data' => $almacenOrigen,
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('almacenOrigen');

                    return $qb;
                },
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            $this->addAlmacenOrigenForm($form);
        } else {
            $almacenOrigen = ($data->getAlmacenOrigen()) ? $data->getAlmacenOrigen() : null;
            $this->addAlmacenOrigenForm($form, $almacenOrigen);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $almacenOrigen = array_key_exists('almacenOrigen', $data) ? $data['almacenOrigen'] : null;
        $this->addAlmacenOrigenForm($form, $almacenOrigen);
    }
}
