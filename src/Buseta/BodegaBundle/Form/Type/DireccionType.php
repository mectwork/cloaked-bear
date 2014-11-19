<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DireccionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calle', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
//                        'style' => 'width: 250px',
                    )
                ))
            ->add('numero', 'text', array(
                    'required' => false,
                    'label'  => 'Número',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('entre_calles', 'text', array(
                    'required' => false,
                    'label'  => 'Entre calles',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('pais', 'country', array(
                    'required' => false,
                    'label'  => 'País',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('subdivision', 'text', array(
                    'required' => false,
                    'label'  => 'Subdivisión (Estado)',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('ciudad', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('activo', null, array(
                    'required' => false,
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\Direccion'
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
