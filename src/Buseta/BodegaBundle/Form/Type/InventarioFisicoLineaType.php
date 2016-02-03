<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventarioFisicoLineaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', 'text', array(
                'required' => true,
                'label' => 'Número',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('descripcion', 'textarea', array(
                'required' => false,
                'label' => 'Descripción',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('producto', 'entity', array(
                'class' => 'BusetaBodegaBundle:Producto',
                'placeholder' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('cantidadReal', 'integer', array(
                'required' => true,
                'label' => 'Cantidad Real',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('cantidadTeorica', 'integer', array(
                'required' => true,
                'read_only' => true,
                'label' => 'Cantidad Teórica',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('seriales', 'textarea', array(
                'required' => false,
                'label'  => 'Seriales',
                'attr'   => array(
                    'class' => 'form-control',
                ),
             ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\InventarioFisicoLinea',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_inventariofisico_linea';
    }
}
