<?php
namespace HatueyERP\TercerosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TerceroFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identificador', null, array(
                'required'  => false,
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('nombres', null, array(
                'required'  => false,
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('apellidos', null, array(
                'required'  => false,
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueyERP\TercerosBundle\Form\Model\TerceroFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueyerp_terceros_tercero_filter';
    }
} 