<?php
namespace Buseta\TallerBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImpuestoFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, array(
                'required'  => false,
                'label' => 'Nombre',
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('numero', null, array(
                'required'  => false,
                'label' => 'Número',
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('tipo', 'choice', array(
                'choices' => array(
                    'fijo'       => 'Fijo',
                    'porcentaje' => 'Porcentaje (%)'),
                'multiple' => false,
                'empty_value' => '---Seleccione---',
                'expanded' => false,
                'label' => 'Tipo',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'width: 250px',
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
            'data_class' => 'Buseta\TallerBundle\Form\Model\ImpuestoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_impuesto_filter';
    }
} 