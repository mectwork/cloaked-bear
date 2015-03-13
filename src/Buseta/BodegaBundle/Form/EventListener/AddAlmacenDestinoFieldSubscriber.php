<?php

namespace Buseta\BodegaBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\BodegaBundle\Entity\Bodega;

class AddAlmacenDestinoFieldSubscriber implements EventSubscriberInterface
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

    private function addAlmacenDestinoForm($form, $almacenDestino = null, $almacenOrigen = null)
    {
        if ($almacenOrigen === null) {
            $form->add('almacenDestino', 'choice', array(
                'choices' => array(),
                'empty_value'   => '---Seleccione almacén destino---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('almacenDestino', 'entity', array(
                'class'         => 'BusetaBodegaBundle:Bodega',
                'empty_value'   => '---Seleccione almacén destino---',
                'auto_initialize' => false,
                'data'          => $almacenDestino,
                'attr' => array(
                    'class' => 'form-control',
                ),
//                'query_builder' => function (EntityRepository $repository) use ($almacenOrigen) {
//                        $qb = $repository->createQueryBuilder('almacenDestino');
//                            //->innerJoin('subgrupos.grupo', 'grupos');
////                        if($almacenOrigen instanceof Bodega){
////                            $qb->where('almacenOrigen = :almacenOrigen')
////                                ->setParameter('almacenOrigen', $almacenOrigen);
////                        }elseif(is_numeric($almacenOrigen)){
////                            $qb->where('almacenOrigen.id = :almacenOrigen')
////                                ->setParameter('almacenOrigen', $almacenOrigen);
////                        }else{
////                            $qb->where('almacenOrigen.valor = :almacenOrigen')
////                                ->setParameter('almacenOrigen', null);
////                        }
//
//                        return $qb;
//                    }
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('almacenDestino');

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
            $this->addAlmacenDestinoForm($form);
        } else {
            $almacenDestino = ($data->getAlmacenDestino()) ? $data->getAlmacenDestino() : null;
            $almacenOrigen = ($almacenDestino) ? $almacenDestino->getAlmacenOrigen() : null;
            $this->addAlmacenDestinoForm($form, $almacenDestino, $almacenOrigen);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $almacenDestino = array_key_exists('almacenDestino', $data) ? $data['almacenDestino'] : null;
        $almacenOrigen = array_key_exists('almacenOrigen', $data) ? $data['almacenOrigen'] : null;
        $this->addAlmacenDestinoForm($form, $almacenDestino, $almacenOrigen);
    }
}
