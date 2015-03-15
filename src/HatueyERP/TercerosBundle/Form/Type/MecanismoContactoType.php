<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MecanismoContactoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('tercero', 'hidden', array(
                'required' => false,
            ))
            ->add('nombre', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('telefono', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('telefono2', 'text', array(
                'required'  => false,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fax', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('dirEnvio', 'checkbox', array(
                'required' => false,
                'label' => 'Dirección de envío',
                'attr'   => array(
                    'class' => 'js-switch',
                )
            ))
            ->add('activo', 'checkbox', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'js-switch',
                )
            ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if ($data && $data->getTercero()) {
                $tercero = $data->getTercero();

                $form->add('direccion', 'entity', array(
                    'data_class' => 'HatueyERPTercerosBundle:Direccion',
                    'query_builder' => function (EntityRepository $er) use ($tercero) {
                        $qb = $er->createQueryBuilder('d')
                        ->join('d.tercero', 't');

                        return $qb
                            ->where($qb->expr()->eq(':tercero','t.id'))
                            ->setParameter('tercero', $tercero);
                    },
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ));
            }

        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueyERP\TercerosBundle\Form\Model\MecanismoContactoModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueyerp_tercerosbundle_mecanismocontacto_type';
    }
}
