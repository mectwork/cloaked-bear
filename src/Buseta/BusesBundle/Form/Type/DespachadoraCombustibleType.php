<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\Type\ChoferInDespachadoraCombustibleType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class DespachadoraCombustibleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chofer',new ChoferInDespachadoraCombustibleType(),array(
                    'label' => ' ',
                )
            )

            ->add('combustible','entity',array(
                'class' => 'BusetaBusesBundle:ConfiguracionCombustible',
                'empty_value' => '---Seleccione---',
                'label' => 'Nomenclador de Combustible',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('cantidadLibros', 'integer', array(
                'required' => true,
                'label' => 'Cantidad de Libros',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            $fechaActualInicial = new \DateTime();
            $fechaActualInicial->setTime(3,0,0);

            $fechaActualFinal = new \DateTime();
            $fechaActualFinal->modify('+1 days');


            $form->add('autobus', 'entity', array(
                'class' => 'BusetaBusesBundle:Autobus',
                'query_builder' => function(EntityRepository $repository) use ($fechaActualInicial,$fechaActualFinal) {
                    $qb = $repository->createQueryBuilder('bus');
                    $qb
                        ->where('NOT EXISTS(SELECT ln FROM BusetaBusesBundle:ListaNegraCombustible ln INNER JOIN ln.autobus a WHERE a=bus AND ln.fechaInicio<=:fechaActual AND ln.fechaFinal>=:fechaActual )')
                        ->andWhere('NOT EXISTS(SELECT d FROM BusetaBusesBundle:DespachadoraCombustible d INNER JOIN d.autobus au WHERE au=bus AND d.created>:fechaActualInicial AND d.created<:fechaActualFinal)')
                        ->orderBy('bus.matricula')
                        ->setParameter('fechaActual', new \DateTime())
                        ->setParameter('fechaActualInicial', $fechaActualInicial)
                        ->setParameter('fechaActualFinal', $fechaActualFinal)
                    ;
                    return $qb;
                },

                'empty_value' => '---Seleccione---',
                'label' => 'Autobús',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ));

        });

/*

        ->add('autobus','entity',array(
        'class' => 'BusetaBusesBundle:Autobus',

        'query_builder' => function(EntityRepository $repository) {
            $qb = $repository->createQueryBuilder('bus');
            $qb
                ->where('NOT EXISTS(SELECT ln FROM BusetaBusesBundle:ListaNegraCombustible ln INNER JOIN ln.autobus a WHERE a=bus AND ln.fechaInicio<=:fechaActual AND ln.fechaFinal>=:fechaActual )')
                ->andWhere('EXISTS(SELECT d FROM BusetaBusesBundle:DespachadoraCombustible d INNER JOIN d.autobus au WHERE au=bus AND d.created=:fechaActual)')
                ->orderBy('bus.matricula')
                ->setParameter('fechaActual', new \DateTime())
                ->setParameter('fechaActualInicial', new \DateTime())
                ->setParameter('fechaActualFinal', new \DateTime())
            ;
            return $qb;
        },

        'empty_value' => '---Seleccione---',
        'label' => 'Autobús',
        'required' => true,
        'attr' => array(
            'class' => 'form-control',
        )
    ))
        ;*/
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Form\Model\DespachadoraCombustibleModel'
        ));
    }

    public function getName()
    {
        return 'buses_despachadora_combustible';
    }
}
