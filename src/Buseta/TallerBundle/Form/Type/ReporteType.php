<?php

namespace Buseta\TallerBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReporteType extends AbstractType
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
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione autobus---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('observaciones','collection',array(
                'type' => new ObservacionType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('medioReporte','entity',array(
                'class' => 'BusetaNomencladorBundle:NMedioReporte',
                'empty_value' => '---Seleccione medio reporte---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('reporta', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Reporta',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('reporta');
                    $qb->andWhere($qb->expr()->eq('reporta.persona', true));

                    return $qb;
                }
            ))
            ->add('esUsuario', null, array(
                'required' => false,
            ))
            ->add('nombrePersona', 'text', array(
                'required' => false,
                'label'  => 'Nombre Persona',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('emailPersona', 'text', array(
                'required' => false,
                'label'  => 'Email Persona',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('telefonoPersona', 'text', array(
                'required' => false,
                'label'  => 'Teléfono Persona',
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
            'data_class' => 'Buseta\TallerBundle\Entity\Reporte'
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
