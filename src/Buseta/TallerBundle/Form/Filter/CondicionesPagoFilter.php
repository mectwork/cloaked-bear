<?php
namespace Buseta\TallerBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CondicionesPagoFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, array(
                'required'  => false,
                'label' => 'Nombre',
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('meses_plazo', null, array(
                'required'  => false,
                'label' => 'Meses de Plazo',
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('dias_plazo', null, array(
                'required'  => false,
                'label' => 'Días de Plazo',
                'trim'      => true,
                'attr'      => array(
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
            'data_class' => 'Buseta\TallerBundle\Form\Model\CondicionesPagoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_condiciones_pago_filter';
    }
} 