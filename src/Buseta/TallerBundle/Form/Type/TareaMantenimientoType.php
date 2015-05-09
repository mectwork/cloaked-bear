<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TareaMantenimientoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $subgrupoSubscriber = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupoSubscriber);
        $grupoSubscriber = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupoSubscriber);

        $builder
            ->add('garantia', 'entity', array(
                'class' => 'BusetaNomencladorBundle:GarantiaTarea',
                'required' => false,
                'label'  => 'Garantía',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('valor', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Tarea',
                'empty_value' => '---Seleccione---',
                'required' => false,
                'label'  => 'Valor',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('kilometros', 'number', array(
                'required' => false,
                'label'  => 'Kilómetros',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('horas', 'number', array(
                'required' => false,
                'label'  => 'Horas',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\TareaMantenimiento',
            'action' => 'POST',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_tareamantenimiento';
    }
}
