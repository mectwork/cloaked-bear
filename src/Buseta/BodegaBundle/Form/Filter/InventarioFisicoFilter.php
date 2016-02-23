<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class InventarioFisicoFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'required' => false,
                'label'  => 'Nombre',
                'attr'   => array(
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
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'placeholder' => '---Seleccione---',
                'label' => 'Bodega',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaInicio', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Inicio',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaFin', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Fin',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('estado', 'choice', array(
                'required' => false,
                'placeholder' => '---Seleccione---',
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
                'placeholder' => '---Seleccione---',
                'required' => false,
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
            'data_class' => 'Buseta\BodegaBundle\Form\Model\InventarioFisicoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_inventario_fisico_filter';
    }
}
