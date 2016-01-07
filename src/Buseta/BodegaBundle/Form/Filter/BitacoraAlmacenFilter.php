<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BitacoraAlmacenFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaMovimiento', 'text', array(
                'required' => false,
                'label' => 'Fecha Movimiento',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('alma', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione---',
                'label' => 'Almacen',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('categoriaProd', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'empty_value' => '---Seleccione---',
                'label' => 'Categoria del producto',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('producto', 'entity', array(
                'class' => 'BusetaBodegaBundle:Producto',
                'empty_value' => '---Seleccione---',
                'label' => 'Producto',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaInicio', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Inicial',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaFin', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Final',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            )) ;


    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\BitacoraAlmacenFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bitacoraalmacen_filter';
    }
}
