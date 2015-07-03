<?php
namespace Buseta\BusesBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DespachadoraCombustibleFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chofer','entity',array(
                'class' => 'BusetaBusesBundle:Chofer',
                'empty_value' => '---Seleccione---',
                'label' => 'Chofer',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('combustible','entity',array(
                'class' => 'BusetaBusesBundle:ConfiguracionCombustible',
                'empty_value' => '---Seleccione---',
                'label' => 'Nomenclador de Combustible',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione---',
                'label' => 'Autobús',
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
            'data_class' => 'Buseta\BusesBundle\Form\Model\DespachadoraCombustibleFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_despachadora_combustible_filter';
    }
} 