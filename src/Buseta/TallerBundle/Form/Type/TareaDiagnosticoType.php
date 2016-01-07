<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddTareaMantenimientoFieldSubscriber;

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

        $objeto = $builder->getFormFactory();

        $grupos = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupos);

        $subgrupos = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupos);

        $tareamantenimiento = new AddTareaMantenimientoFieldSubscriber($objeto);
        $builder->addEventSubscriber($tareamantenimiento);



        $builder
            ->add('descripcion', 'textarea', array(
                'required' => true,
                'label'  => 'Observación de tarea',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 120px',
                ),
            ))

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
