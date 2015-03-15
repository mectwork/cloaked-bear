<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use HatueySoft\UploadBundle\Form\Type\DocumentModelAbstractType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TerceroType extends AbstractType
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
            ->add('foto', new DocumentModelAbstractType(), array(
                'label' => 'Foto',
            ))
            ->add('identificador', 'text', array(
                'required' => false,
            ))
            ->add('nombres', 'text', array())
            ->add('apellidos', 'text', array(
                'required' => false,
            ))
            ->add('nombreComercial', 'text', array(
                'required' => false,
            ))
            ->add('nombreFiscal', 'text', array(
                'required' => false,
            ))
            ->add('descripcion', 'textarea', array(
                'required'  => false,
                'label'     => 'Descripción',
            ))
            ->add('cifNif', 'text', array(
                'required' => false,
                'label' => 'CIF/NIF',
            ))
//            ->add('is_persona', 'checkbox', array(
//                'required' => false,
//                'label' => 'Es persona  ',
//                'attr'   => array(
//                    'class' => 'js-switch',
//                )
//            ))
//
//            ->add('is_cliente', 'checkbox', array(
//                'required' => false,
//                'label' => 'Es cliente  ',
//                'attr'   => array(
//                    'class' => 'js-switch',
//                )
//            ))
//
//            ->add('is_proveedor', 'checkbox', array(
//                'required' => false,
//                'label' => 'Es proveedor  ',
//                'attr'   => array(
//                    'class' => 'js-switch',
//                )
//            ))
//
//            ->add('is_institucion', 'checkbox', array(
//                'required' => false,
//                'label' => 'Es institución  ',
//                'attr'   => array(
//                    'class' => 'js-switch',
//                )
//            ))
            ->add('activo', 'checkbox', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'js-switch',
                    )
                ))
//            ->add('persona', new PersonaType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueyERP\TercerosBundle\Form\Model\TerceroModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terceros_tercero_type';
    }
}
