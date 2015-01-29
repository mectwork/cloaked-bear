<?php

namespace Buseta\TallerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MantenimientoPreventivoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kilometraje', 'number', array(
                'required' => true,
                'label' => 'Kilometraje',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('fechaInicio', 'date', array(
                'required' => true,
                'label'  => 'Fecha Inicio',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaFinal', 'date', array(
                'required' => true,
                'label'  => 'Fecha Final',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('grupo','entity',array(
                'class' => 'BusetaNomencladorBundle:Grupo',
                'empty_value' => '---Seleccione un grupo---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('subgrupo','entity',array(
                'class' => 'BusetaNomencladorBundle:Subgrupo',
                'empty_value' => '---Seleccione un subgrupo---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('tarea', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Tarea',
                'empty_value' => '---Seleccione una tarea---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione un autobus---',
                'required' => true,
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
            'data_class' => 'Buseta\TallerBundle\Entity\MantenimientoPreventivo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_mantenimientopreventivo';
    }
}
