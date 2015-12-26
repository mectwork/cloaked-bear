<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Entity\TareaMantenimiento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TareaDiagnosticoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', 'textarea', array(
                'required' => true,
                'label'  => 'Observación de tarea',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 120px',
                ),
            ))
            ->add('grupo')
            ->add('subgrupo')
//            ->add('tareamantenimiento', 'collection', array(
//                'type' => new TareaMantenimiento(),
//                'label'  => false,
//                'required' => true,
//                'by_reference' => false,
//                'allow_add' => true,
//                'allow_delete' => true,
//            ))

            ->add('tareamantenimiento', 'entity', array(
                'class'         => 'BusetaTallerBundle:TareaMantenimiento',
                'empty_value'   => '---Seleccione---',
                'auto_initialize' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))

//            ->add('tareamantenimiento', 'text', array(
//                'required' => true,
//                'label'  => 'Tarea de Mantenimiento',
//                'attr'   => array(
//                    'class' => 'form-control',
//                ),
//            ))
//            ->add('diagnostico')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\TareaDiagnostico'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_tareadiagnostico';
    }
}
