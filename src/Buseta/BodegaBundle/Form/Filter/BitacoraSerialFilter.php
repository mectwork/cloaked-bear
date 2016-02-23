<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BitacoraSerialFilter extends AbstractType
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
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'placeholder' => '---Seleccione---',
                'label' => 'Almacen',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('categoriaProd', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'placeholder' => '---Seleccione---',
                'label' => 'Categoria del producto',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('producto', 'entity', array(
                'class' => 'BusetaBodegaBundle:Producto',
                'placeholder' => '---Seleccione---',
                'label' => 'Producto',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaInicio', 'date', array(
                'widget' => 'single_text',
                'label' => 'Fecha Inicial',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaFin', 'date', array(
                'widget' => 'single_text',
                'label' => 'Fecha Final',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tipoMovimiento', 'choice', array(
                'required' => false,
                'placeholder' => '---Seleccione---',
                //luego implementar 'translation_domain' => 'BusetaBodegaBundle',
                'choices' => array(
                    'V+' => '[V+]Recepcion desde Proveedor',
                    'M+' => '[M+]Movimiento de entrada a Bodega',
                    'M-' => '[M-]Movimiento de salida de Bodega',
                    'I+' => '[I+]Aumento por Inventario Fisico',
                    'I-' => '[I-]Disminucion por Inventario Fisico',
                    'P-' => '[P-]Salida hacia Produccion',
                ),
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('serial', 'text', array(
                'required' => false,
                'label' => 'Serial',
                'attr' => array(
                    'class' => 'form-control',
                )
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\BitacoraSerialFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bitacoraserial_filter';
    }
}
