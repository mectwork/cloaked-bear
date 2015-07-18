<?php

namespace Buseta\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FechaSistemaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activo', 'checkbox', array(
                'required' => false,
            ))
            ->add('fecha','date',array(
                    'required' => false,
                    'label' => 'Fecha de Sistema',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array(
                        'class' => 'pickadate-fecha'
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
            'data_class' => 'Buseta\CoreBundle\Entity\FechaSistema'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_corebundle_fechasistematype';
    }
}
