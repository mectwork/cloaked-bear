<?php

namespace Buseta\BusesBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\NomencladorBundle\Entity\Marca;

class AddModeloFieldSubscriber implements EventSubscriberInterface
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
            FormEvents::PRE_SUBMIT     => 'preBind'
        );
    }

    private function addModeloForm($form, $modelo = null, $marca = null)
    {
        if($marca === null) {
            $form->add('modelo','choice',array(
                'choices' => array(),
                'empty_value'   => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ), 
            ));
        } else {
            $form->add('modelo','entity', array(
                'class'         => 'BusetaNomencladorBundle:Modelo',
                'empty_value'   => '---Seleccione---',
                'auto_initialize' => false,
                'data'          => $modelo,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($marca) {
                        $qb = $repository->createQueryBuilder('modelo')
                            ->innerJoin('modelo.marca', 'marca');
                        if($marca instanceof Marca){
                            $qb->where('marca = :marca')
                                ->setParameter('marca', $marca);
                        }elseif(is_numeric($marca)){
                            $qb->where('marca.id = :marca')
                                ->setParameter('marca', $marca);
                        }else{
                            $qb->where('marca.valor = :marca')
                                ->setParameter('marca', null);
                        }

                        return $qb;
                    }
            ));
        }
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null == $data) {
            $this->addModeloForm($form);
        } else {
            //$province = ($data->city) ? $data->city->getModelo() : null ;
            $modelo = ($data->getModelo()) ? $data->getModelo() : null ;
            $marca = ($modelo) ? $modelo->getMarca() : null ;
            $this->addModeloForm($form, $modelo, $marca);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $modelo = array_key_exists('modelo', $data) ? $data['modelo'] : null;
        $marca = array_key_exists('marca', $data) ? $data['marca'] : null;
        $this->addModeloForm($form, $modelo, $marca);
    }
}