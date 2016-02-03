<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Buseta\BodegaBundle\Entity\CategoriaProducto;

class MovimientosProductosFilter extends AbstractType
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
            ->add('categoria_producto', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'label' => 'Categoría de Producto',
                'required' => false,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('grupo', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Grupo',
                'label' => 'Grupo',
                'required' => false,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('subgrupo', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Subgrupo',
                'label' => 'Subgrupo',
                'required' => false,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\MovimientosProductosFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_movimientosproductos_filter';
    }
}
