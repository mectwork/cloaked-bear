<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;

class ProductoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $subgrupos = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupos);
        $grupos = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupos);

        $builder
            ->add('codigo', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('nombre', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('uom','entity',array(
                    'class' => 'BusetaNomencladorBundle:UOM',
                    'empty_value' => '---Seleccione una UOM---',
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('condicion','entity',array(
                    'class' => 'BusetaNomencladorBundle:Condicion',
                    'empty_value' => '---Seleccione una condición---',
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('bodega','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'required' => false,
                'empty_value' => '---Seleccione una bodega---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('precio_costo', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('precio_salida', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('minimo_bodega', 'integer', array(
                'required' => true,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('maximo_bodega', 'integer', array(
                'required' => true,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('activo', null, array(
                    'required' => false,
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\Producto',
            'action' => 'POST'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_producto';
    }
}
