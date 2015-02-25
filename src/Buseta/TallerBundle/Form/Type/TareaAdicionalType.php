<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Form\EventListener\AddTareaMantenimientoFieldSubscriber;
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
        $tarea = new AddTareaMantenimientoFieldSubscriber($objeto);
        $builder->addEventSubscriber($tarea);
        $builder
//            ->add('tarea', 'entity', array(
//                'class' => 'BusetaNomencladorBundle:Tarea',
//                'label' => 'Tarea',
//                'attr'   => array(
//                    'class' => 'form-control',
//                )
//            ))
            ->add('descripcion', 'textarea', array(
                'required' => true,
                'label'  => 'Observación de tarea',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 120px',
                )
            ))
            ->add('garantiaTarea','entity',array(
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

            ->add('fechaEstimada','date',array(
                'widget' => 'single_text',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('horaInicio', 'text', array(
                'required' => true,
                'label'  => 'Hora inicio',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('horaFinal', 'text', array(
                'required' => true,
                'label'  => 'Hora final',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('horasLaboradas', 'hidden', array(
                'required' => false,
                'mapped' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ));
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
