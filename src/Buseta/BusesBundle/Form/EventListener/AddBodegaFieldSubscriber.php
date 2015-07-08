<?php

namespace Buseta\BusesBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\BodegaBundle\Entity\Bodega;

class AddBodegaFieldSubscriber implements EventSubscriberInterface
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
            FormEvents::PRE_SUBMIT      => 'preBind'
        );
    }

    private function addBodegaForm($form, $bodega = null)
    {
        $form->add('bodega', 'entity', array(
            'class'         => 'BusetaBodegaBundle:Bodega',
            'auto_initialize' => false,
            'empty_value'   => '---Seleccione---',
            'data' => $bodega,
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('bodega');

                    return $qb;
                }
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            $this->addBodegaForm($form);
        } else {
            $bodega = ($data->getBodega()) ? $data->getBodega() : null ;
            $this->addBodegaForm($form, $bodega);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $bodega = array_key_exists('bodega', $data) ? $data['bodega'] : null;
        $this->addBodegaForm($form, $bodega);
    }
}