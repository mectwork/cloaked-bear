<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class BodegaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
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
            ->add('nombre', 'text', array(
                    'required' => true,
                    'label' => 'Nombre',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('descripcion', 'textarea', array(
                    'required' => false,
                    'label' => 'Descripción',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('direccion', 'textarea', array(
                    'required' => false,
                    'label' => 'Dirección',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('responsable', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Responsable',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('responsable');
                    $qb->join('responsable.usuario', 'usuario')
                        ->andWhere($qb->expr()->isNotNull('usuario'));

                    return $qb;
                },
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\Bodega',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_bodega';
    }
}
