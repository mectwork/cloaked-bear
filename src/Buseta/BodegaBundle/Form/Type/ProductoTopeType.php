<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoTopeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('producto', 'entity', array(
                'class' => 'BusetaBodegaBundle:Producto',
                'label' => 'Producto',
                'required' => true,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'label' => 'Almacen',
                'required' => true,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('min', 'text', array(
                'required' => true,
                'label' => 'Minimo',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('max', 'text', array(
                'required' => true,
                'label' => 'Maximo',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('comentarios', 'textarea', array(
                'required' => false,
                'label'  => 'Comentarios',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
             ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\ProductoTope'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_productotope';
    }
}
