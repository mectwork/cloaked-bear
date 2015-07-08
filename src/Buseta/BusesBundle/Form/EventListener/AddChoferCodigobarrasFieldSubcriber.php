<?php

namespace Buseta\BusesBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddChoferCodigobarrasFieldSubcriber implements EventSubscriberInterface{

    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory  = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA    => 'preSetData',
        );
    }

    public function preSetData(FormEvent $event){
        $data = $event->getData();
        $form = $event->getForm();

        $required = true;
        if($data && $data->getCodigoBarras() !== null){
            $required = false;
        }

        $form->add('codigoBarras','password',array(
            'required' => $required,
            'label' => 'Código de Barras',
        ));
    }
}