<?php
namespace HatueySoft\SequenceBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SecuenciaFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'required' => false,
                'label'  => 'Nombre de Secuencia',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tipo', 'choice', array(
                'label'  => 'Tipo',
                'empty_value' => '---Seleccione---',
                'choices' => array(
                    'incremental' => 'Incremental',
                    'fija' => 'Fija',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('prefijo', 'text', array(
                'required' => false,
                'label'  => 'Prefijo',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('sufijo', 'text', array(
                'required' => false,
                'label'  => 'Sufijo',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueySoft\SequenceBundle\Form\Model\SecuenciaFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueysoft_secuencia_filter';
    }
}
