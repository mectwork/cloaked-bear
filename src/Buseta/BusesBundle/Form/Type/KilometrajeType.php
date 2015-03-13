<?php

namespace Buseta\BusesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KilometrajeType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valor', 'text', array(
                'required' => false,
                'attr'   => array(
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
            'data_class'    => 'Buseta\BusesBundle\Entity\Kilometraje',
            'default'       => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_kilometraje_type';
    }
}
