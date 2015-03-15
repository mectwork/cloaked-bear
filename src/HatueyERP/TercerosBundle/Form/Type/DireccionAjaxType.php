<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DireccionAjaxType
 * @package HatueyERP\TercerosBundle\Form\Type
 * @author: dundivet <dundivet@emailn.de>
 */
class DireccionAjaxType extends AbstractType
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('calle', 'textarea', array(
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('pais','country',array(
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('subdivision',null, array(
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('ciudad', null, array(
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'HatueyERP\TercerosBundle\Entity\Direccion',
                'action' => $this->router->generate('terceros_direccion_create_ajax'),
                'method' => 'POST',
                'csrf_protection' => false,
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueyerp_terceros_direccion_type';
    }
} 