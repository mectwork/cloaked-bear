<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalidaBodegaFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaInicio', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Inicial',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaFin', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Final',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('almacenOrigen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione---',
                'label' => 'Bodega Origen',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('almacenDestino', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione---',
                'label' => 'Bodega Destino',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('centroCosto', 'entity', array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione---',
                'label' => 'Centro de Costo',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('responsable', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'empty_value' => '---Seleccione---',
                'label' => 'Responsable',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('ordenTrabajo', 'entity', array(
                'class' => 'BusetaTallerBundle:OrdenTrabajo',
                'empty_value' => '---Seleccione---',
                'label' => 'Orden de Trabajo',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('estado', 'choice', array(
                'required' => false,
                'empty_value' => '---Seleccione---',
                'translation_domain' => 'BusetaTallerBundle',
                'choices' => array(
                    'CO' => 'estado.CO',
                    'BO' => 'estado.BO',
                    'PR' => 'estado.PR',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('producto','entity',array(
                'class' => 'BusetaBodegaBundle:Producto',
                'label' => 'Producto',
                'empty_value' => '---Seleccione---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\SalidaBodegaFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_salidabodega_filter';
    }
} 