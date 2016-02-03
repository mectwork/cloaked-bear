<?php

namespace Buseta\TallerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImpuestoType extends AbstractType
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
                    'attr'   => array(
                        'class' => 'form-control',
                        'style' => 'width: 250px',
                    ),
                ))
            ->add('numero', 'text', array(
                    'required' => false,
                    'label'  => 'Número',
                    'attr'   => array(
                        'class' => 'form-control',
                        'style' => 'width: 250px',
                    ),
                ))
            ->add('tipo', 'choice', array(
                    'choices' => array(
                        'fijo'       => 'Fijo',
                        'porcentaje' => 'Porcentaje (%)', ),
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                        'style' => 'width: 250px',
                    ),
                ))
            ->add('tarifa', 'number', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                        'style' => 'width: 250px',
                    ),
                ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\Impuesto',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_impuesto';
    }
}
