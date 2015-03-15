<?php

namespace Buseta\BusesBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddMarcaFieldSubscriber implements EventSubscriberInterface
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

    private function addMarcaForm($form, $marca = null)
    {
        $form->add('marca', 'entity', array(
            'class'         => 'BusetaNomencladorBundle:Marca',
            'auto_initialize' => false,
            'empty_value'   => '---Seleccione---',
            'data' => $marca,
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('marca');

                    return $qb;
                }
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            $this->addMarcaForm($form);
        } else {
            //$marca = ($data->city) ? $data->city->getSubmarca()->getMarca() : null ;
            $marca = ($data->getMarca()) ? $data->getMarca() : null ;
            $this->addMarcaForm($form, $marca);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $marca = array_key_exists('marca', $data) ? $data['marca'] : null;
        $this->addMarcaForm($form, $marca);
    }
}