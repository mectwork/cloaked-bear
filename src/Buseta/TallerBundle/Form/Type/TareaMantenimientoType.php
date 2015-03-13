<?php

namespace Buseta\TallerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;

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
            ->add('valor', 'text', array(
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
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\NomencladorBundle\Entity\Tarea',
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
