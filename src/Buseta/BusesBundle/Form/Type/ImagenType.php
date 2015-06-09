<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\UploadBundle\Form\Type\UploadResourcesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImagenType extends AbstractType
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
            ->add('imagenFrontal', new UploadResourcesType(), array(
                'required' => false,
                'label' => 'Imagen Frontal',
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))->add('imagenFrontalInterior', new UploadResourcesType(), array(
                'required' => false,
                'label' => 'Imagen Frontal Interior',
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('imagenLateralD', new UploadResourcesType(), array(
                'required' => false,
                'label' => 'Imagen Lateral Derecha',
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('imagenLateralI', new UploadResourcesType(), array(
                'required' => false,
                'label' => 'Imagen Lateral Izquierda',
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('imagenTrasera', new UploadResourcesType(), array(
                'required' => false,
                'label' => 'Imagen Trasera',
                'attr' => array(
                    'class' => 'hidden',
                ),
            ))
            ->add('imagenTraseraInterior', new UploadResourcesType(), array(
                'required' => false,
                'label' => 'Imagen Trasera Interior',
                'attr' => array(
                    'class' => 'hidden',
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
                'data_class' => 'Buseta\BusesBundle\Form\Model\ImagenModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buses_autobus_imagenes';
    }

}
