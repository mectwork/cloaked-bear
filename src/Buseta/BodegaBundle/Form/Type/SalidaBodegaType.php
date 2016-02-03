<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Buseta\BodegaBundle\Form\EventListener\AddAlmacenDestinoFieldSubscriber;
use Buseta\BodegaBundle\Form\EventListener\AddAlmacenOrigenFieldSubscriber;
use Doctrine\ORM\EntityRepository;

class SalidaBodegaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $almacenDestino = new AddAlmacenDestinoFieldSubscriber($objeto);
        $builder->addEventSubscriber($almacenDestino);
        $almacenOrigen = new AddAlmacenOrigenFieldSubscriber($objeto);
        $builder->addEventSubscriber($almacenOrigen);

        $builder
            ->add('salidas_productos', 'collection', array(
                'type' => new SalidaBodegaProductoType(),
                'label'  => false,
                'required' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('responsable', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Responsable',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('responsable');
                    $qb->join('responsable.usuario', 'usuario')
                        ->andWhere($qb->expr()->isNotNull('usuario'));

                    return $qb;
                },
            ))
            ->add('observaciones', 'textarea', array(
                'required' => true,
                'label'  => 'Observaciones',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tipo_ot', 'choice', array(
                'label'  => 'Tipo de Orden de Trabajo',
                'choices' => array(
                    'rapida' => 'Rápida',
                    'normal' => 'Normal',
                ),
                'data' => 'normal',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('centro_costo', 'entity', array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione---',
                'label' => 'Centro de Costo',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('orden_trabajo', 'entity', array(
                'class' => 'BusetaTallerBundle:OrdenTrabajo',
                'empty_value' => '---Seleccione---',
                'label' => 'Orden de Trabajo',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fecha', 'date', array(
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Fecha',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('control_entrega_material', 'text', array(
                'required' => true,
                'label'  => 'Control Entrega de Materiales',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('estado_documento', 'choice', array(
                'required' => false,
                'read_only' => true,
                'empty_value' => '---Seleccione---',
                'translation_domain' => 'BusetaTallerBundle',
                'choices' => array(
                    'CO' => 'estado.CO',
                    'BO' => 'estado.BO',
                    'PR' => 'estado.PR',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\SalidaBodega',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_salida_bodega';
    }
}
