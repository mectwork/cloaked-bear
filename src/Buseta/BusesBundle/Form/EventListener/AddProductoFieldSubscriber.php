<?php

namespace Buseta\BusesBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\BodegaBundle\Entity\Bodega;

class AddProductoFieldSubscriber implements EventSubscriberInterface
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

    private function addProductoForm($form, $producto = null, $bodega = null)
    {
        if($bodega === null) {
            $form->add('producto','choice',array(
                'choices' => array(),
                'empty_value'   => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('producto','entity', array(
                'class'         => 'BusetaBodegaBundle:Producto',
                'empty_value'   => '---Seleccione---',
                'auto_initialize' => false,
                'data'          => $producto,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($bodega) {
                        $qb = $repository->createQueryBuilder('producto')
                            ->innerJoin('producto.bodega', 'bodega');
                        if($bodega instanceof Bodega){
                            $qb->where('bodega = :bodega')
                                ->setParameter('bodega', $bodega);
                        }elseif(is_numeric($bodega)){
                            $qb->where('bodega.id = :bodega')
                                ->setParameter('bodega', $bodega);
                        }else{
                            $qb->where('bodega.valor = :bodega')
                                ->setParameter('bodega', null);
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
            $this->addProductoForm($form);
        } else {
            //$province = ($data->city) ? $data->city->getProducto() : null ;
            $producto = ($data->getProducto()) ? $data->getProducto() : null ;
            $bodega = ($producto) ? $producto->getBodega() : null ;
            $this->addProductoForm($form, $producto, $bodega);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $producto = array_key_exists('producto', $data) ? $data['producto'] : null;
        $bodega = array_key_exists('bodega', $data) ? $data['bodega'] : null;
        $this->addProductoForm($form, $producto, $bodega);
    }
}
