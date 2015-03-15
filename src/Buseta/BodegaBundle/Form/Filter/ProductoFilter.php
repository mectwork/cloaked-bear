<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductoFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
                'empty_value' => '---Seleccione---',
                'label' => 'Unidad de Medida (UOM)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('condicion', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Condicion',
                'empty_value' => '---Seleccione---',
                'label' => 'Condición',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('bodega', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'required' => false,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('categoriaProducto', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'label' => 'Categoría de Producto',
                'required' => false,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\ProductoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_producto_filter';
    }
} 