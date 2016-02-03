<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 13/03/15
 * Time: 1:21.
 */

namespace Buseta\TallerBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoricoMantenimientosFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('autobus', 'text', array(
                'required' => false,
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('grupo', 'text', array(
                'required' => false,
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('subgrupo', 'text', array(
                'required' => false,
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tarea', 'text', array(
                'required' => false,
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Buseta\TallerBundle\Form\Model\HistoricoMantenimientosFilterModel',
                'method' => 'GET',
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'historicomantenimientos';
    }
}
