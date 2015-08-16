<?php

namespace Buseta\BodegaBundle\Form\Type;

use HatueySoft\UploadBundle\Form\Type\UploadResourcesType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaType extends TerceroHiddenAndIdType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('activo', 'checkbox', array(
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\PersonaModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bodega_tercero_persona';
    }
}
