<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Buseta\BodegaBundle\Form\EventListener\AddAlmacenDestinoFieldSubscriber;
use Buseta\BodegaBundle\Form\EventListener\AddAlmacenOrigenFieldSubscriber;

class MovimientoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $almacenDestino = new AddAlmacenDestinoFieldSubscriber($objeto);
        $builder->addEventSubscriber($almacenDestino);
        $almacenOrigen = new AddAlmacenOrigenFieldSubscriber($objeto);
        $builder->addEventSubscriber($almacenOrigen);

        $builder
            ->add('movimientos_productos', 'collection', array(
                'type' => new MovimientosProductosType(),
                'label'  => false,
                'required' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\Movimiento',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_movimiento';
    }
}
