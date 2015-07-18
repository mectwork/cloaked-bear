<?php

namespace Buseta\CoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CambioHoraSistemaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hora','time',array(
                    'required' => false,
                    'label' => 'Hora de Cambio',
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'pickatime'
                    )
                ))
            ->add('activo', 'checkbox', array(
                'required' => false,
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\CoreBundle\Entity\CambioHoraSistema'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_corebundle_horacambiosistematype';
    }
}
