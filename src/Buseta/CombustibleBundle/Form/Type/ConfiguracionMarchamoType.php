<?php

namespace Buseta\CombustibleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracionMarchamoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden')
            ->add('bodega', 'entity', array(
                'required' => false,
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '.:Seleccione:.',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('producto', 'entity', array(
                'required' => false,
                'class' => 'BusetaBodegaBundle:Producto',
                'empty_value' => '.:Seleccione:.',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\CombustibleBundle\Form\Model\ConfiguracionMarchamoModel',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'combustible_configuracion_marchamo';
    }
}
