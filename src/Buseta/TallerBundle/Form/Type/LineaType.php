<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Form\EventListener\AddProductoFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;

class LineaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $productoSubscriber = new AddProductoFieldSubscriber($objeto);
        $builder->addEventSubscriber($productoSubscriber);
        $subgrupoSubscriber = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupoSubscriber);
        $grupoSubscriber = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupoSubscriber);

        $builder
            ->add('numero', 'text', array(
                    'required' => true,
                    'label'  => 'Número',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('tipo', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('condicion', 'text', array(
                'required' => true,
                'label'  => 'Condición',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('cantidad_pedido', 'integer', array(
                    'required' => true,
                   'label'  => 'Cantidad de pedido',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('precio_producto', 'integer', array(
                'required' => true,
                'label'  => 'Precio de producto',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('monto', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            /*->add('producto','entity',array(
                    'class' => 'BusetaBodegaBundle:Producto',
                    'empty_value' => '---Seleccione un producto---',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ))*/
//            ->add('bodegas','entity',array(
//                'class' => 'BusetaBodegaBundle:Bodega',
//                'empty_value' => '---Seleccione una bodega---',
//                'required' => true,
//                'attr' => array(
//                    'class' => 'form-control',
//                )
//            ))
            ->add('impuesto', 'entity', array(
                    'class' => 'BusetaTallerBundle:Impuesto',
                    'empty_value' => '---Seleccione un impuesto---',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\Linea',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_linea';
    }
}
