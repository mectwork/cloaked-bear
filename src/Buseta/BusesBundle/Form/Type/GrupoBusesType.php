<?php

namespace Buseta\BusesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GrupoBusesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @ORM\Column(name="color", type="string", length=7)
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'required' => true,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('color', 'text', array(
                'required' => false,
                'label' => 'Color de texto',
                'attr'   => array(
                    'class' => 'minicolors-input colorpicker',
                    'data-control' => 'wheel',
                ),
            ))
            ->add('colorTexto', 'text', array(
                'required' => false,
                'label' => 'Color de texto',
                'attr'   => array(
                    'class' => 'minicolors-input colorpicker',
                    'data-control' => 'saturation',
                ),
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Entity\GrupoBuses'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_busesbundle_grupobuses';
    }
}
