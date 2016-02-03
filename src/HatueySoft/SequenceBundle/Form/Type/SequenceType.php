<?php

namespace HatueySoft\SequenceBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SequenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => false,
                'read_only' => true,
                'label'  => 'sequence.name',
                'translation_domain' => 'HatueySoftSequenceBundle',
            ))
            ->add('type', 'choice', array(
                'label'  => 'sequence.type',
                'translation_domain' => 'HatueySoftSequenceBundle',
                'placeholder' => '---Seleccione---',
                'choices' => array(
                    'incremental' => 'Incremental',
                    //'fixed' => 'Fija',
                ),
            ))
            ->add('prefix', 'text', array(
                'required' => false,
                'label'  => 'sequence.prefix',
                'translation_domain' => 'HatueySoftSequenceBundle',
            ))
            ->add('suffix', 'text', array(
                'required' => false,
                'label'  => 'sequence.suffix',
                'translation_domain' => 'HatueySoftSequenceBundle',
            ))
            ->add('numberNextInterval', 'integer', array(
                'required' => false,
                'label'  => 'sequence.numberNextInterval',
                'translation_domain' => 'HatueySoftSequenceBundle',
            ))
            ->add('numberIncrement', 'integer', array(
                'required' => false,
                'label'  => 'sequence.numberIncrement',
                'translation_domain' => 'HatueySoftSequenceBundle',
            ))
            ->add('padding', 'integer', array(
                'required' => false,
                'label'  => 'sequence.padding',
                'translation_domain' => 'HatueySoftSequenceBundle',
            ))
            ->add('active', 'checkbox', array(
                'required' => false,
                'label' => 'sequence.active',
                'translation_domain' => 'HatueySoftSequenceBundle',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueySoft\SequenceBundle\Entity\Sequence',
        ));

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueysoft_sequence_type';
    }
}
