<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\BodegaBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\BodegaBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Buseta\BodegaBundle\Form\Type\PrecioProductoType;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $subgrupos = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupos);
        $grupos = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupos);

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
            ->add('categoriaProducto', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'label' => 'Categoría de Producto',
                'required' => false,
                'empty_value' => '---Seleccione categoría de producto---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('minimo_bodega', 'integer', array(
                'required' => false,
                'label' => 'Mínimo en Bodega',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('maximo_bodega', 'integer', array(
                'required' => false,
                'label' => 'Máximo en Bodega',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('precioProducto','collection',array(
                'type' => new PrecioProductoType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
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
            'data_class' => 'Buseta\BodegaBundle\Entity\Producto',
            'action' => 'POST'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_producto';
    }
}
