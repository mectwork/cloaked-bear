<?php

namespace Buseta\TallerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;

class TareaAdicionalType extends AbstractType
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
            ->add('tarea', 'textarea', array(
                'required' => true,
                'label'  => 'Tarea',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 120px',
                )
            ))
            ->add('descripcion', 'textarea', array(
                'required' => true,
                'label'  => 'Descripción',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 120px',
                )
            ))
            ->add('garantias_tareas','entity',array(
                'class' => 'BusetaNomencladorBundle:GarantiaTarea',
                'label'  => 'Garantía de tarea',
                'empty_value' => '---Seleccione una garantía---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            /*
            ->add('grupos','entity',array(
                'class' => 'BusetaNomencladorBundle:Grupo',
                'empty_value' => '---Seleccione un grupo---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('subgrupos','entity',array(
                'class' => 'BusetaNomencladorBundle:Subgrupo',
                'empty_value' => '---Seleccione un subgrupo---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            */

            ->add('fecha_estimada','date',array(
                'widget' => 'single_text',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('hora_inicio', 'text', array(
                'required' => true,
                'label'  => 'Hora inicio',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('hora_final', 'text', array(
                'required' => true,
                'label'  => 'Hora final',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('horas_laboradas', 'hidden', array(
                'required' => false,
                'mapped' => false,
                'attr'   => array(
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
            'data_class' => 'Buseta\TallerBundle\Entity\TareaAdicional'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_tarea_adicional';
    }
}
