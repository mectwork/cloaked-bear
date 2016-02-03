<?php

namespace Buseta\BodegaBundle\Form\Type;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Buseta\BodegaBundle\Form\Model\BitacoraAlmacenModel;

class BitacoraAlmacenType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();


        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('cantMovida', 'text', array(
                'required' => false,
                'label' => 'cantMovida',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaMovimiento', 'text', array(
                'required' => false,
                'label' => 'Fecha Movimiento',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('tipoMovimiento', 'text', array(
                'required' => false,
                'label' => 'Tipo Movimiento',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))->add('producto', 'entity', array(
                'class' => 'BusetaBodegaBundle:Producto',
                'label' => 'Producto',
                'required' => false,
                'empty_value' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\BitacoraAlmacen',
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bodega_bitacoraalmacen';
    }
}
