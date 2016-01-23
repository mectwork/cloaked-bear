<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Form\EventListener\AddSolicitudFieldSubscriber;
use Buseta\TallerBundle\Form\Type\TareaDiagnostico;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiagnosticoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new AddSolicitudFieldSubscriber());
        $attr['readonly'] = true;

        $builder
            ->add('numero', 'text', array(
                'required' => false,
                'label'  => 'Número',
                'attr' => $attr,
            ))
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione---',
                'label' => 'Autobús',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('prioridad', 'entity', array(
                'class' => 'BusetaNomencladorBundle:PrioridadSolicitud',
                'empty_value' => '---Seleccione prioridad---',
                'required' => false,
            ))




            ->add('tareaDiagnostico', 'collection', array(
                'type' => new TareaDiagnosticoType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))

            ->add('observaciones','collection',array(
                'type' => new ObservacionDiagnosticoType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\Diagnostico'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_reporte';
    }
}
