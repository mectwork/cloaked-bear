<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrecioProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('precio', 'number', array(
                'required' => false,
                'label' => 'Precio',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('costo', 'number', array(
                'required' => false,
                'label' => 'Costo',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaInicio','date',array(
                'widget' => 'single_text',
                'label'  => 'Fecha Inicio',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaFin','date',array(
                'widget' => 'single_text',
                'label'  => 'Fecha Fin',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('activo', null, array(
                'label' => 'Activo',
                'required' => false,
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\PrecioProducto',
            'action' => 'POST'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_precio_producto';
    }
}
