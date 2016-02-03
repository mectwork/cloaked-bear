<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerceroFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', 'text', array(
                'required' => false,
                'label' => 'Código',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('nombres', 'text', array(
                'required' => false,
                'label' => 'Nombres',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('apellidos', 'text', array(
                'required' => false,
                'label' => 'Apellidos',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('alias', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\TerceroFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tercero_filter';
    }
}
