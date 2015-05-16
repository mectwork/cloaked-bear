<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DireccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'required' => false,
                'read_only' => true,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.nombre',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('calle', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.calle',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('codigoPostal', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.codigoPostal',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('localidad', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.localidad',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('pais', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.pais',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('region', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.region',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('latitud', 'integer', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.latitud',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('longitud', 'integer', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'direccion.longitud',
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
            'data_class' => 'Buseta\BodegaBundle\Entity\Direccion',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_direccion';
    }
}
