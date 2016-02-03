<?php

namespace Buseta\TallerBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ReporteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $formEvent) {
            $form = $formEvent->getForm();
            $data = $formEvent->getData();

            $propertyAccesor = PropertyAccess::createPropertyAccessor();
            $numero = $propertyAccesor->getValue($data, 'numero');
            $attr = array();
            if ($numero !== null) {
                $attr['readonly'] = true;
            }

            $form->add('numero', 'text', array(
                'required' => false,
                'label'  => 'Número',
                'attr' => $attr,
            ));
        });
        $builder
            ->add('autobus','entity',array(
                'class' => 'BusetaBusesBundle:Autobus',
                'placeholder' => '---Seleccione autobus---',
                'required' => true,
            ))
            ->add('prioridad', 'entity', array(
                'class' => 'BusetaNomencladorBundle:PrioridadSolicitud',
                'placeholder' => '---Seleccione prioridad---',
                'required' => false,
            ))
            ->add('grupo', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Grupo',
                'placeholder' => '---Seleccione grupo---',
                'required' => false,
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
                'class' => 'BusetaNomencladorBundle:MedioReporte',
                'placeholder' => '---Seleccione medio reporte---',
                'required' => true,
            ))
            ->add('reporta', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Reporta',
                'query_builder' => function(EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('reporta');
                    $qb->join('reporta.persona', 'p')
                        ->andWhere($qb->expr()->isNotNull('p'));

                    return $qb;
                }
            ))
            ->add('esUsuario', null, array(
                'required' => false,
            ))
            ->add('nombrePersona', 'text', array(
                'required' => false,
                'label'  => 'Nombre Persona',
            ))
            ->add('emailPersona', 'text', array(
                'required' => false,
                'label'  => 'Email Persona',
            ))
            ->add('telefonoPersona', 'text', array(
                'required' => false,
                'label'  => 'Teléfono Persona',
            ))
//            ->add('estado', 'choice', array(
//                'required' => false,
//                'placeholder' => '---Seleccione---',
//                'translation_domain' => 'BusetaTallerBundle',
//                'choices' => array(
//                    'CO' => 'estado.CO',
//                    'BO' => 'estado.BO',
//                    'PR' => 'estado.PR',
//                ),
//                'attr'   => array(
//                    'class' => 'form-control',
//                    'disabled' => 'disabled',
//                ),
//            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
