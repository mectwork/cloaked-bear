<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use HatueyERP\TercerosBundle\Form\Type\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DireccionType extends AbstractType
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
            ->add('tercero', 'hidden_entity', array(
                'class' => 'HatueyERP\TercerosBundle\Entity\Tercero',
                'required' => false,
            ))
            ->add('nombre', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                    'readonly' => true,
                )
            ))
            ->add('calle', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('calle2', 'text', array(
                'required'  => false,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('codigoPostal', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('localidad', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('region', 'text', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
//            ->add('pais', 'text', array(
//                'required' => false,
//                'attr'   => array(
//                    'class' => 'form-control',
//                )
//            ))
        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueyERP\TercerosBundle\Form\Model\DireccionModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terceros_direccion_type';
    }
}
