<?php

namespace Buseta\BusesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroType extends AbstractType
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
            ->add('filtroAceite', new FiltroAceiteType())

            ->add('filtroDiesel', new FiltroDieselType())

            ->add('filtroHidraulico', new FiltroHidraulicoType())

            ->add('filtroCaja', new FiltroCajaType())

            ->add('filtroTransmision', new FiltroTransmisionType())

            ->add('filtroAgua', new FiltroAguaType())
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Form\Model\FiltroModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buses_autobus_filtro';
    }

}
