<?php

namespace HatueySoft\SequenceBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SecuenciaType extends AbstractType
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
                    'read_only' => true,
                    'label'  => 'Nombre de Secuencia',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('tipo', 'choice', array(
                'label'  => 'Tipo',
                'empty_value' => '---Seleccione---',
                'choices' => array(
                    'incremental' => 'Incremental',
                    'fija' => 'Fija',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('prefijo', 'text', array(
                'required' => false,
                'label'  => 'Prefijo',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('sufijo', 'text', array(
                'required' => false,
                'label'  => 'Sufijo',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('siguienteValor', 'text', array(
                'required' => false,
                'label'  => 'Siguiente Valor',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('cantidadIncrementar', 'integer', array(
                'required' => false,
                'label'  => 'Cantidad a Incrementar',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('cantidadRelleno', 'integer', array(
                'required' => false,
                'label'  => 'Cantidad Relleno',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('relleno', 'text', array(
                'required' => false,
                'label'  => 'Relleno',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('codigo', 'integer', array(
                'required' => false,
                'label'  => 'Código',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
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
            'data_class' => 'HatueySoft\SequenceBundle\Entity\Secuencia',
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueysoft_secuencia_type';
    }
}
