<?php

namespace Buseta\TallerBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MantenimientoPreventivoFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grupo', null, array(
                'required' => false,
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('subgrupo', null, array(
                'required' => false,
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('tarea', null, array(
                'required' => false,
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('autobus', null, array(
                'required' => false,
                'trim' => true,
                'attr' => array(
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
            'data_class' => 'Buseta\TallerBundle\Form\Model\MantenimientoPreventivoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'mantenimientopreventivo';
    }
}