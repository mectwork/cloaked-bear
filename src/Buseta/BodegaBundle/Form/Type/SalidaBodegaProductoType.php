<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalidaBodegaProductoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producto', 'hidden_entity', array(
                'class' => 'BusetaBodegaBundle:Producto',
                'required' => false,
            ))
            ->add('cantidad', 'text', array(
                'required' => false,
                'label' => 'Cantidad',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('seriales', 'textarea', array(
                'required' => false,
                'label'  => 'Seriales',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'nombrePreSetData'))
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'codigoPreSetData'))
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'descripcionPreSetData'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\SalidaBodegaProducto',
        ));
    }

    public function nombrePreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if($data != null && $data->getProducto()) {
            $form->add('nombre', 'text', array(
                'data' => $data->getProducto()->getNombre(),
                'mapped' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('nombre', 'text', array(
                'mapped' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        }
    }

    public function codigoPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if($data != null && $data->getProducto()) {
            $form->add('codigo', 'text', array(
                'data' => $data->getProducto()->getCodigo(),
                'mapped' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('codigo', 'text', array(
                'mapped' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        }
    }

    public function descripcionPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        if($data != null && $data->getProducto()) {
            $form->add('descripcion', 'text', array(
                'data' => $data->getProducto()->getDescripcion(),
                'mapped' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('descripcion', 'text', array(
                'mapped' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_salida_bodega_producto';
    }
}
