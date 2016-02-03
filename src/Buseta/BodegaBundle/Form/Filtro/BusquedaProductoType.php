<?php

namespace Buseta\BodegaBundle\Form\Filtro;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusquedaProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', 'text', array(
                'required' => false,
                'label' => 'Código',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nombre', 'text', array(
                'required' => false,
                'label' => 'Nombre',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('uom', 'entity', array(
                'class' => 'BusetaNomencladorBundle:UOM',
                'placeholder' => '---Seleccione UOM---',
                'label' => 'Unidad de Medida (UOM)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('condicion', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Condicion',
                'placeholder' => '---Seleccione condición---',
                'label' => 'Condición',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('bodega', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'required' => false,
                'placeholder' => '---Seleccione bodega---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('categoriaProducto', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'label' => 'Categoría de Producto',
                'required' => false,
                'placeholder' => '---Seleccione categoría de producto---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
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
