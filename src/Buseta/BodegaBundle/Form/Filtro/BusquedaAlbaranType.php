<?php

namespace Buseta\BodegaBundle\Form\Filtro;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class BusquedaAlbaranType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroReferencia', 'text', array(
                'required' => false,
                'label'  => 'Nro.Referencia',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('consecutivoCompra', 'text', array(
                'required' => false,
                'label'  => 'Nro.Documento',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'label' => 'Bodega',
                'placeholder' => '---Seleccione---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tercero', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('t');
                    return $qb->join('t.proveedor', 'proveedor')
                        ->where($qb->expr()->isNotNull('proveedor.id'));
                },
                'placeholder' => '---Seleccione proveedor---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))

            /*->add('fechaMovimiento','date',array(
                'widget' => 'single_text',
                'label'  => 'Fecha Movimiento',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaContable','date',array(
                'widget' => 'single_text',
                'label'  => 'Fecha Contable',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))*/
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
        return 'data_busqueda_albaran_type';
    }
}
