<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BitSerialFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serial', 'text', array(
                'required' => false,
                'label' => 'Serial',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'placeholder' => '---Seleccione---',
                'label' => 'Almacen',
                'required' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('producto', 'entity', array(
                'class' => 'BusetaBodegaBundle:Producto',
                'placeholder' => '---Seleccione---',
                'label' => 'Producto',
                'read_only' => true,
                'required' => false,
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
            'data_class' => 'Buseta\BodegaBundle\Form\Model\BitSerialFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bitserial_filter';
    }
}
