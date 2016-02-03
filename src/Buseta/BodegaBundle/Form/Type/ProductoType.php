<?php

namespace Buseta\BodegaBundle\Form\Type;

use Buseta\BodegaBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\BodegaBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Buseta\BodegaBundle\Form\Model\ProductoModel;

class ProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $subgrupoSubscriber = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupoSubscriber);
        $grupoSubscriber = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupoSubscriber);

        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('codigo', 'text', array(
                'required' => false,
                'label' => 'Código ATSA',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('codigoA', 'text', array(
                'required' => false,
                'label' => 'Código A',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nombre', 'text', array(
                'required' => false,
                'label' => 'Nombre',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('uom', 'entity', array(
                'class' => 'BusetaNomencladorBundle:UOM',
                'placeholder' => '---Seleccione---',
                'label' => 'Unidad de Medida (UOM)',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('condicion', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Condicion',
                'placeholder' => '---Seleccione---',
                'label' => 'Condición',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('categoriaProducto', 'entity', array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'label' => 'Categoría de Producto',
                'required' => false,
                'placeholder' => '---Seleccione---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('descripcion', 'textarea', array(
                'required' => false,
                'label'  => 'Descripción',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('proveedor', 'entity', array(
                'required' => false,
                'placeholder' => '---Seleccione---',
                'class' => 'BusetaBodegaBundle:Tercero',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('t')
                        ->leftJoin('t.proveedor', 'p')
                        ->orderBy('t.nombres', 'ASC');
                    return $qb->where($qb->expr()->isNotNull('p'));
                },
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('activo', 'checkbox', array(
                'label' => 'Activo',
                'required' => false,
            ))
            ->add('tieneNroSerie', 'checkbox', array(
                'label' => 'Tiene Numero Serie',
                'required' => false,
            ))
            ->add('tieneRefInterna', 'checkbox', array(
                'label' => 'Tiene Ref. Interna',
                'required' => false,
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\ProductoModel',
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bodega_producto';
    }
}
