<?php

namespace Buseta\CombustibleBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoferInServicioCombustibleType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chofer','entity',array(
                'class' => 'BusetaBusesBundle:Chofer',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('codigobarras','password',array(
                    'required' => false,
                    'label' => 'Código de Barras',
                    'attr' => array(
                        'autocomplete' => 'off',
                    )
                ))
            ->add('pin', 'password', array(
                    'required' => false,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Buseta\CombustibleBundle\Form\Model\ChoferInServicioCombustible',
            ));
    }

    public function getName()
    {
        return 'combustible_choferinservicio_combustible_type';
    }
}