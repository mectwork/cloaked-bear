<?php

namespace HatueyERP\TercerosBundle\Form\Type;

use HatueySoft\UploadBundle\Form\Type\DocumentModelAbstractType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonaType extends TerceroHiddenAndIdType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('isPersona', 'checkbox', array(
                'required'  => false,
                'label'     => '¿Es Persona?'
            ))
            ->add('fechaNacimiento', 'birthday', array(
                'required' => false,
                'widget' => 'single_text',
                'format' => 'd/M/y',
                'label' => 'persona.fechaNacimiento',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('edad', 'integer', array(
                'required' => false,
                'label' => 'persona.edad',
                'translation_domain' => 'HatueyERPTercerosBundle',
                'attr' => array(
                    'readonly' => true,
                ),
            ))
            ->add('cedula', 'text', array(
                'required' => false,
                'label' => 'persona.cedula',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('nacionalidad','entity',array(
                'required' => false,
                'class' => 'OlimpiadaNomencladorBundle:NNacionalidad',
                'empty_value' => 'select.empty_value',
                'label' => 'persona.nacionalidad',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('nombreMadre', 'text', array(
                'required' => false,
                'label' => 'persona.nombreMadre',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('cedulaMadre', 'text', array(
                'required' => false,
                'label' => 'persona.cedulaMadre',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('nombrePadre', 'text', array(
                'required' => false,
                'label' => 'persona.nombrePadre',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('cedulaPadre', 'text', array(
                'required' => false,
                'label' => 'persona.cedulaPadre',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('email', 'email', array(
                'required' => false,
                'label' => 'persona.email',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('sexo', 'choice', array(
                'required' => false,
                'choices' => array(
                    'masculino' => 'sexo.masculino',
                    'femenino' => 'sexo.femenino',
                    'no_aplica' => 'sexo.no_aplica',
                ),
                'label' => 'persona.sexo',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('profesion','entity',array(
                'required' => false,
                'class' => 'OlimpiadaNomencladorBundle:NProfesion',
                'empty_value' => 'select.empty_value',
                'label' => 'persona.profesion',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('trabaja', 'checkbox', array(
                'required' => false,
                'attr'   => array(
                    'class' => 'js-switch',
                )
            ))
            ->add('idioma1','entity',array(
                'class' => 'OlimpiadaNomencladorBundle:NIdioma',
                'required' => false,
                'empty_value' => 'select.empty_value',
                'label' => 'persona.idioma1',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('idioma2','entity',array(
                'class' => 'OlimpiadaNomencladorBundle:NIdioma',
                'required' => false,
                'empty_value' => 'select.empty_value',
                'label' => 'persona.idioma2',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('pasatiemposHabilidades','entity',array(
                'class' => 'OlimpiadaNomencladorBundle:NPasatiempoHabilidad',
                'required' => false,
                'multiple' => true,
                'label' => 'persona.pasatiemposHabilidades',
                'empty_value' => 'select.empty_value',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('estadoCivil','entity',array(
                'class' => 'OlimpiadaNomencladorBundle:NEstadoCivil',
                'required' => false,
                'label' => 'persona.estadoCivil',
                'empty_value' => 'select.empty_value',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('tallaCamiseta', 'text', array(
                'required' => false,
                'label' => 'persona.tallaCamiseta',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('tallaPantalon', 'text', array(
                'required' => false,
                'label' => 'persona.tallaPantalon',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
            ->add('tallaShort', 'text', array(
                'required' => false,
                'label' => 'persona.tallaShort',
                'translation_domain' => 'HatueyERPTercerosBundle',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueyERP\TercerosBundle\Form\Model\PersonaModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'terceros_persona_type';
    }
}
