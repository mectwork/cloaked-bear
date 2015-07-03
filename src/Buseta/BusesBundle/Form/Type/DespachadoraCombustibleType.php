<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\EventListener\AddDespachadoraCombustibleCodigobarrasFieldSubcriber;
use Buseta\BusesBundle\Form\EventListener\AddDespachadoraCombustiblePinFieldSubcriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DespachadoraCombustibleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chofer','entity',array(
                'class' => 'BusetaBusesBundle:Chofer',
                'empty_value' => '---Seleccione---',
                'label' => 'Chofer',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('combustible','entity',array(
                'class' => 'BusetaBusesBundle:ConfiguracionCombustible',
                'empty_value' => '---Seleccione---',
                'label' => 'Nomenclador de Combustible',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione---',
                'label' => 'Autobús',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('cantidadLibros', 'integer', array(
                'required' => true,
                'label' => 'Cantidad de Libros',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Entity\DespachadoraCombustible'
        ));
    }

    public function getName()
    {
        return 'buses_despachadora_combustible';
    }
}
