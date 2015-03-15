<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProveedorType extends TerceroHiddenAndIdType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('isProveedor', 'checkbox', array(
                'required'  => false,
                'label'     => '¿Es Proveedor?'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueyERP\TercerosBundle\Form\Model\ProveedorModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terceros_proveedor_type';
    }
}
