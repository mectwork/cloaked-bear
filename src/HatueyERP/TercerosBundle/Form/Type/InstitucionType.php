<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstitucionType extends TerceroHiddenAndIdType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('isInstitucion', 'checkbox', array(
                'required'  => false,
                'label'     => '¿Es Institución?'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueyERP\TercerosBundle\Form\Model\InstitucionModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terceros_institucion_type';
    }
}
