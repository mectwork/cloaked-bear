<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\BodegaBundle\Entity\Producto;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdenNecesidadProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producto')
            ->add('cantidad', 'text', array(
                'required' => false,
                'label' => 'Cantidad',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('seriales', 'textarea', array(
                'required' => false,
                'label'  => 'Seriales',
                'attr'   => array(
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
            'data_class' => 'Buseta\TallerBundle\Entity\OrdenNecesidadProducto',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_ordennecesidadproducto';
    }
}
