<?php
namespace Buseta\BusesBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoferFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombres', 'text', array(
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('apellidos', 'text', array(
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('cedula', 'text', array(
                'label' => 'Cédula',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('estadoCivil','entity',array(
                'class' => 'BusetaNomencladorBundle:EstadoCivil',
                'empty_value' => '---Seleccione---',
                'label' => 'Estado Civil',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('nacionalidad','entity',array(
                'class' => 'BusetaNomencladorBundle:Nacionalidad',
                'empty_value' => '---Seleccione---',
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
            'data_class' => 'Buseta\BusesBundle\Form\Model\ChoferFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_chofer_filter';
    }
} 