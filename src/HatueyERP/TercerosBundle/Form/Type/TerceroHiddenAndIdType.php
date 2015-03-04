<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TerceroHiddenAndIdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('tercero', 'hidden_entity', array(
                'required' => false,
                'class' => 'HatueyERP\TercerosBundle\Entity\Tercero',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terceros_tercero_hidden_and_id';
    }
}
