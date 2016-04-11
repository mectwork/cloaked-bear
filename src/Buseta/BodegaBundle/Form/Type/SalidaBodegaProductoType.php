<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalidaBodegaProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'id',
                'hidden',
                array(
                    'required' => false,
                )
            )
            ->add(
                'producto',
                'entity',
                array(
                    'required' => true,
                    'class' => 'BusetaBodegaBundle:Producto',
                    'label' => 'Producto',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'cantidad',
                'text',
                array(
                    'required' => false,
                    'label' => 'Cantidad',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                )
            )
            ->add(
                'seriales',
                'text',
                array(
                    'required' => false,
                    'label' => false,
                    'attr' => array(
                        'style' => "display: none",
                    ),
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Buseta\BodegaBundle\Entity\SalidaBodegaProducto',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_salida_bodega_producto';
    }
}
