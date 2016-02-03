<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Buseta\BodegaBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\BodegaBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new AddGrupoFieldSubscriber($builder->getFormFactory()));
        $builder->addEventSubscriber(new AddSubgrupoFieldSubscriber($builder->getFormFactory()));
        $builder
            ->add('codigo', 'text', array(
                'required' => false,
                'label' => 'Código',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('nombre', 'text', array(
                'required' => false,
                'label' => 'Nombre',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('condicion', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Condicion',
                'empty_value' => '---Seleccione---',
                'label' => 'Condición',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('proveedor', 'entity', array(
                'class' => 'BusetaBodegaBundle:Proveedor',
                'empty_value' => '---Seleccione---',
                'label' => 'Proveedor',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('codigoAlternativo', 'text', array(
                'required' => false,
                'label' => 'Código Alternativo',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\ProductoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_producto_filter';
    }
}
