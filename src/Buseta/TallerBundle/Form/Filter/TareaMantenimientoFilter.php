<?php
namespace Buseta\TallerBundle\Form\Filter;

use Buseta\BodegaBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TareaMantenimientoFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $subgrupoSubscriber = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupoSubscriber);
        $grupoSubscriber = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupoSubscriber);

        $builder
            ->add('valor','entity',array(
                'class' => 'BusetaNomencladorBundle:Tarea',
                'empty_value' => '---Seleccione---',
                'label' => 'Valor',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('garantia','entity',array(
                'class' => 'BusetaNomencladorBundle:GarantiaTarea',
                'empty_value' => '---Seleccione---',
                'label' => 'Garantía',
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
            'data_class' => 'Buseta\TallerBundle\Form\Model\TareaMantenimientoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tareamantenimiento_filter';
    }
} 