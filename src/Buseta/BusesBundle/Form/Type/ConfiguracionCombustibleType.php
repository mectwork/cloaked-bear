<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\EventListener\AddBodegaFieldSubscriber;
use Buseta\BusesBundle\Form\EventListener\AddProductoFieldSubscriber;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfiguracionCombustibleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $producto = new AddProductoFieldSubscriber($objeto);
        $builder->addEventSubscriber($producto);
        $bodega = new AddBodegaFieldSubscriber($objeto);
        $builder->addEventSubscriber($bodega);

        $builder
            ->add('combustible', 'entity', array(
                'required' => false,
                'class' => 'BusetaNomencladorBundle:Combustible',
                'empty_value' => '.:Seleccione:.',
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Entity\ConfiguracionCombustible',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'buses_configuracion_combustible';
    }
}
