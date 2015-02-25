<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddTareaMantenimientoFieldSubscriber;
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
            $objeto = $builder->getFormFactory();
            $tareaSubscriber = new AddTareaMantenimientoFieldSubscriber($objeto);
            $builder->addEventSubscriber($tareaSubscriber);
            $subgrupoSubscriber = new AddSubgrupoFieldSubscriber($objeto);
            $builder->addEventSubscriber($subgrupoSubscriber);
            $grupoSubscriber = new AddGrupoFieldSubscriber($objeto);
            $builder->addEventSubscriber($grupoSubscriber);

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
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione autobús---',
                'label' => 'Autobús',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('horas', 'number', array(
                'required' => false,
                'label'  => 'Horas',
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
