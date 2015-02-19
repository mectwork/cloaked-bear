<?php

namespace Buseta\BodegaBundle\Form\Filtro;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusquedaProductoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', 'text', array(
                'required' => false,
                'label' => 'Código',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('nombre', 'text', array(
                'required' => false,
                'label' => 'Nombre',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('uom', 'entity', array(
                'class' => 'BusetaNomencladorBundle:UOM',
                'empty_value' => '---Seleccione UOM---',
                'label' => 'Unidad de Medida (UOM)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('condicion', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Condicion',
                'empty_value' => '---Seleccione condición---',
                'label' => 'Condición',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('bodega', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'required' => false,
                'empty_value' => '---Seleccione bodega---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection' => false,
            ));
    }

    public function getName()
    {
        return 'data_busqueda_producto_type';
    }
}