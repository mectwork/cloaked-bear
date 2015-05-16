<?php

namespace Buseta\BodegaBundle\Form\Type;

use Buseta\UploadBundle\Form\Type\UploadResourcesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProveedorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('terceroId', 'integer', array(
                'required' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('proveedorId', 'integer', array(
                'required' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('foto', new UploadResourcesType(), array(
                'required' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('codigo', 'text', array(
                'required' => true,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.codigo',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('alias', 'text', array(
                'required' => true,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.alias',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nombres', 'text', array(
                'required' => true,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.nombres',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('apellidos', 'text', array(
                'required' => true,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.apellidos',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('activo', 'checkbox', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.activo',
            ))
            ->add('cif_nif', 'text', array(
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.cifnif',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('moneda', 'entity', array(
                'required' => true,
                'class' => 'BusetaNomencladorBundle:Moneda',
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.moneda',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('creditoLimite', 'number', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.credito',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('observaciones', 'textarea', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.observaciones',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('email', 'email', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.email',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('web', 'url', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'proveedor.web',
                'attr' => array(
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
            'data_class' => 'Buseta\BodegaBundle\Form\Model\ProveedorModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_proveedor';
    }
}
