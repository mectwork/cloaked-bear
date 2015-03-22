<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DireccionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('calle')
            ->add('codigoPostal')
            ->add('localidad')
            ->add('pais')
            ->add('region')
            ->add('tercero')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\Direccion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_direccion';
    }
}
