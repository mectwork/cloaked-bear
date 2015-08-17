<?php

namespace Buseta\BodegaBundle\Form\Type;

use Buseta\BodegaBundle\Form\Model\TerceroModel;
use HatueySoft\UploadBundle\Form\Type\UploadResourcesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TerceroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('foto', new UploadResourcesType(), array(
                'required' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('codigo', 'text', array(
                    'required' => false,
                    'label' => 'Código',
                ))
            ->add('nombres', 'text', array(
                    'required' => false,
                ))
            ->add('apellidos', 'text', array(
                    'required' => false,
                ))
            ->add('cifNif', 'text', array(
                'label' => 'CIF/NIF',
                'required' => true,
            ))
            ->add('alias', 'text', array(
                    'required' => false,
                ))
            ->add('usuario','entity',array(
                'class' => 'HatueySoftSecurityBundle:User',
            ))
            ->add('activo', 'checkbox', array(
                'required' => false,
            ))
            ->add('email', 'email', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'tercero.email',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('web', 'url', array(
                'required' => false,
                'translation_domain' => 'BusetaBodegaBundle',
                'label' => 'tercero.web',
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
            'data_class' => 'Buseta\BodegaBundle\Form\Model\TerceroModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bodega_tercero';
    }
}
