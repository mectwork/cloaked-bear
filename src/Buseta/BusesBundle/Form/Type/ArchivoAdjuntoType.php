<?php

namespace Buseta\BusesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArchivoAdjuntoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
                'attr' => array(
                    'style' => 'display:none',
                    'accept' => 'application/pdf,'.
                        'application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document,'.
                        'application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,'.
                        'application/zip, application/x-compressed-zip'.
                        'application/x-rar-compressed',
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Form\Model\ArchivoAdjuntoModel',
        ));
    }

    public function getName()
    {
        return 'archivo_adjunto_type';
    }
}
