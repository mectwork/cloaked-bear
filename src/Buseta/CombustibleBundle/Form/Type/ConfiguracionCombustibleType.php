<?php

namespace Buseta\CombustibleBundle\Form\Type;

use Buseta\CombustibleBundle\Form\EventListener\AddBodegaFieldSubscriber;
use Buseta\CombustibleBundle\Form\EventListener\AddProductoFieldSubscriber;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracionCombustibleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$objeto = $builder->getFormFactory();
        $producto = new AddProductoFieldSubscriber($objeto);
        $builder->addEventSubscriber($producto);
        $bodega = new AddBodegaFieldSubscriber($objeto);
        $builder->addEventSubscriber($bodega);*/

        $builder
            ->add('combustible', 'entity', array(
                'required' => false,
                'class' => 'BusetaNomencladorBundle:Combustible',
                'placeholder' => '.:Seleccione:.',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('producto', 'entity', array(
                'required' => false,
                'class' => 'BusetaBodegaBundle:Producto',
                'placeholder' => '.:Seleccione:.',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
            ->add('bodega', 'entity', array(
                'required' => false,
                'class' => 'BusetaBodegaBundle:Bodega',
                'placeholder' => '.:Seleccione:.',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\CombustibleBundle\Entity\ConfiguracionCombustible',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'combustible_configuracion_combustible';
    }
}
