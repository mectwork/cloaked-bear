<?php

namespace Buseta\BodegaBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MecanismoContactoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'mecanismo_contacto.nombre',
            ))
            ->add('telefono', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'mecanismo_contacto.telefono',
            ))
            ->add('telefono2', 'text', array(
                'required'  => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'mecanismo_contacto.telefono2',
            ))
            ->add('fax', 'text', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'mecanismo_contacto.fax',
            ))
            ->add('dirEnvio', 'checkbox', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'mecanismo_contacto.dirEnvio',
            ))
            ->add('activo', 'checkbox', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'mecanismo_contacto.activo',
            ));

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if ($data && $data->getTercero()) {
                $tercero = $data->getTercero();

                $form->add('direccion', 'entity', array(
                    'class' => 'BusetaBodegaBundle:Direccion',
                    'query_builder' => function (EntityRepository $er) use ($tercero) {
                        $qb = $er->createQueryBuilder('d')
                            ->join('d.tercero', 't');

                        return $qb
                            ->where($qb->expr()->eq(':tercero','t.id'))
                            ->setParameter('tercero', $tercero);
                    },
                    'required' => false,
                    'translation_domain' => 'BusetaBodegaBundle',
                    'label' => 'mecanismo_contacto.direccion'
                ));
            }

        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\MecanismoContacto',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_mecanismocontacto';
    }
}
