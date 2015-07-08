<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\EventListener\AddChoferCodigobarrasFieldSubcriber;
use Buseta\BusesBundle\Form\EventListener\AddChoferPinFieldSubcriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChoferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $factory = $builder->getFormFactory();
        $pinFieldSubcriber = new AddChoferPinFieldSubcriber($factory);
        $codigobarrasFieldSubcriber = new AddChoferCodigobarrasFieldSubcriber($factory);

        $builder
            ->add('nombres', 'text', array(
                'required' => true,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('apellidos', 'text', array(
                'required' => true,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('cedula', 'text', array(
                'required' => true,
                'label' => 'Cédula',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('identificador', 'text', array(
                'required' => true,
                'label' => 'Identificador',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
        ;

        $builder
            ->addEventSubscriber($pinFieldSubcriber)
            ->addEventSubscriber($codigobarrasFieldSubcriber);

        $builder
            ->add('direccion','textarea',array())
            ->add('telefono')
            ->add('genero','choice',array(
                    'choices' => array(
                        'm' => 'Masculino',
                        'f' => 'Femenino'
                    )
                ))
            ->add('estadoCivil','entity',array(
                'class' => 'BusetaNomencladorBundle:EstadoCivil',
                'empty_value' => '---Seleccione---',
                'label' => 'Estado Civil',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('nacionalidad','entity',array(
                'class' => 'BusetaNomencladorBundle:Nacionalidad',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaNacimiento', 'date', array(
                'widget' => 'single_text',
                'required' => false,
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Entity\Chofer'
        ));
    }

    public function getName()
    {
        return 'buses_chofer';
    }
}
