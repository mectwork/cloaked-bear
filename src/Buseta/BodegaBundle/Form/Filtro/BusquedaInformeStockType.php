<?php

namespace Buseta\BodegaBundle\Form\Filtro;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class BusquedaInformeStockType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('almacen','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('producto','entity',array(
                'class' => 'BusetaBodegaBundle:Producto',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fecha','date',array(
                'widget' => 'single_text',
                'required' => false,
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection' => false,
            ));
    }

    public function getName()
    {
        return 'data_busqueda_informe_stock_type';
    }
}