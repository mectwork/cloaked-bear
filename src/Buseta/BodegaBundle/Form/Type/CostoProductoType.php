<?php

namespace Buseta\BodegaBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CostoProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('costo', 'number', array(
                'required' => false,
                'label' => 'Costo',
            ))
            ->add('proveedor', 'entity', array(
                'required' => false,
                'class' => 'BusetaBodegaBundle:Tercero',
                'empty_value' => '.:Seleccione:.',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('t');
                    return $qb->innerJoin('t.proveedor', 'p')
                        ->where($qb->expr()->isNotNull('p'))
                        ->orderBy('t.nombres', 'ASC');
                },
                'attr' => array(
                    'class' => 'chosen'
                ),
            ))
            ->add('codigoAlternativo', 'text', array(
                'required' => false,
                'label' => 'Código'
            ))
            ->add('activo', null, array(
                'label' => 'Activo',
                'required' => false,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\CostoProducto',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_costo_producto';
    }
}
