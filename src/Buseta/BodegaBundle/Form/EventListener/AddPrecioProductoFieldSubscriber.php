<?php

namespace Buseta\TallerBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\BodegaBundle\Entity\Producto;

class AddPrecioProductoFieldSubscriber implements EventSubscriberInterface
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

    private function addPrecioProductoForm($form, $precio = null, $producto = null)
    {
        if ($producto === null) {
            $form->add('precio_producto', 'choice', array(
                'choices' => array(),
                'placeholder'   => '---Seleccione un precio---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            /*$form->add('precio_producto','text',array(
                'class' => 'BusetaBodegaBundle:Producto',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('p')
                        ->where('p.producto_id = true');
                },
                'required' => false,
            ))*/

            $form->add('productos', 'entity', array(
                'class'         => 'BusetaBodegaBundle:Producto',
                'placeholder'   => '---Seleccione un producto---',
                'auto_initialize' => false,
                'data'          => $producto,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($subgrupo) {
                        $qb = $repository->createQueryBuilder('productos')
                            ->innerJoin('productos.subgrupo', 'subgrupos');
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
            $subgrupo = ($producto) ? $producto->getSubgrupo() : null;
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
