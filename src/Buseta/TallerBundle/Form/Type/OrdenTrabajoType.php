<?php

namespace Buseta\TallerBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdenTrabajoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', 'text', array(
                'required' => false,
                'label'  => 'Número',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('realizada_por', 'text', array(
                'required' => false,
                'label'  => 'Responsable',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('diagnostico', 'text', array(
                'required' => false,
                'label'  => 'Diagnóstico',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('observaciones', 'textarea', array(
                'required' => false,
                'label'  => 'Observaciones',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('prioridad', 'choice', array(
                'required' => false,
                'label'  => 'Prioridad',
                'choices' => array(
                    'rapida'=>'Rápida',
                    'normal' => 'Normal',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('ayudante', 'text', array(
                'required' => false,
                'label'  => 'Ayudante',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione un autobus---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('tarea_adicional','collection',array(
                'type' => new TareaAdicionalType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('fecha_inicio', 'date', array(
                'required' => false,
                'label'  => 'Fecha inicio',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fecha_final', 'date', array(
                'required' => false,
                'label'  => 'Fecha final',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('duracion_dias', 'text', array(
                'required' => false,
                'label'  => 'Duración de días',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('duracion_horas_laboradas', 'text', array(
                'required' => false,
                'label'  => 'Duración de horas laboradas',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('revisado', null, array(
                'required' => false,
            ))
            ->add('aprobado', null, array(
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
            'data_class' => 'Buseta\TallerBundle\Entity\OrdenTrabajo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_ordentrabajo';
    }
}
