<?php

namespace Buseta\BusesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformacionExtraType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('valorUnidad', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('numeroUnidad', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('anno', 'number', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('marcaCajacambio', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tipoCajacambio', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('carterCapacidadlitros', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('bateria1', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('bateria2', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('aceitecajacambios', 'entity', array(
                'class' => 'BusetaNomencladorBundle:AceiteCajaCambios',
                'placeholder' => '---Seleccione---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('aceitehidraulico', 'entity', array(
                'class' => 'BusetaNomencladorBundle:AceiteHidraulico',
                'placeholder' => '---Seleccione---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('aceitemotor', 'entity', array(
                'class' => 'BusetaNomencladorBundle:AceiteMotor',
                'placeholder' => '---Seleccione---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('aceitetransmision', 'entity', array(
                'class' => 'BusetaNomencladorBundle:AceiteTransmision',
                'placeholder' => '---Seleccione---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Form\Model\InformacionExtraModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buses_autobus_informacion_extra';
    }
}
