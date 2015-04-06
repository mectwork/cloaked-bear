<?php

namespace Buseta\BodegaBundle\Form\EventListener;

use Buseta\NomencladorBundle\Entity\Subgrupo;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

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
            FormEvents::PRE_SUBMIT     => 'preBind',
        );
    }

    private function addProductoForm($form, $producto = null, $subgrupo = null)
    {
        if ($subgrupo === null) {
            $form->add('productos', 'choice', array(
                'choices' => array(),
                'empty_value'   => '---Seleccione un producto---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('productos', 'entity', array(
                'class'         => 'BusetaBodegaBundle:Producto',
                'empty_value'   => '---Seleccione un producto---',
                'auto_initialize' => false,
                'data'          => $producto,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($subgrupo) {
                        $qb = $repository->createQueryBuilder('productos')
                            ->innerJoin('productos.subgrupos', 'subgrupos');
                        if ($subgrupo instanceof Subgrupo) {
                            $qb->where('subgrupos = :subgrupos')
                                ->setParameter('subgrupos', $subgrupo);
                        } elseif (is_numeric($subgrupo)) {
                            $qb->where('subgrupos.id = :subgrupos')
                                ->setParameter('subgrupos', $subgrupo);
                        } else {
                            $qb->where('subgrupos.valor = :subgrupos')
                                ->setParameter('subgrupos', null);
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
            $this->addProductoForm($form);
        } else {
            //$province = ($data->city) ? $data->city->getProducto() : null ;
            $producto = ($data->getProductos()) ? $data->getProductos() : null;
            $subgrupo = ($producto) ? $producto->getSubgrupos() : null;
            $this->addProductoForm($form, $producto, $subgrupo);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $producto = array_key_exists('productos', $data) ? $data['productos'] : null;
        $subgrupo = array_key_exists('subgrupos', $data) ? $data['subgrupos'] : null;
        $this->addProductoForm($form, $producto, $subgrupo);
    }
}
