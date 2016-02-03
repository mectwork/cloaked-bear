<?php

namespace Buseta\BodegaBundle\Form\Filtro;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusquedaTerceroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', 'text', array(
                'required' => false,
                'label' => 'Código',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nombres', 'text', array(
                'required' => false,
                'label' => 'Nombres',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('apellidos', 'text', array(
                'required' => false,
                'label' => 'Apellidos',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('alias', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('cliente', 'checkbox', array(
                'required' => false,
            ))
            ->add('institucion', 'checkbox', array(
                'label' => 'Institución',
                'required' => false,
            ))
            ->add('proveedor', 'checkbox', array(
                'required' => false,
            ))
            ->add('persona', 'checkbox', array(
                'required' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection' => false,
            ));
    }

    public function getName()
    {
        return 'data_busqueda_tercero_type';
    }
}
