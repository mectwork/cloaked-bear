<?php

namespace Buseta\BodegaBundle\Form\Type;

use Buseta\BodegaBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\BodegaBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\BodegaBundle\Form\Model\ProductoModel;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$objeto = $builder->getFormFactory();
        $subgrupos = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupos);
        $grupos = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupos);*/

        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('grupos', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Grupo',
                'empty_value' => '---Seleccione---',
                'label' => 'Grupo',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('subgrupos', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Subgrupo',
                'empty_value' => '---Seleccione---',
                'label' => 'Subgrupo',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
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
                'empty_value' => '---Seleccione---',
                'label' => 'Unidad de Medida (UOM)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('condicion', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Condicion',
                'empty_value' => '---Seleccione---',
                'label' => 'Condición',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('categoriaProducto', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'label' => 'Categoría de Producto',
                'required' => false,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('precioProducto', 'collection', array(
                'type' => new PrecioProductoType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('activo', 'checkbox', array(
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
            'data_class' => 'Buseta\BodegaBundle\Form\Model\ProductoModel',
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bodega_producto';
    }
}
