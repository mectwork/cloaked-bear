<?php

namespace Buseta\SecurityBundle\Form\Type;

use HatueySoft\UploadBundle\Form\Type\UploadResourcesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class UserType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder,$options);

        $builder
            ->add('nombres', 'text', array(
                'label' => 'usuario.data.nombres',
                'translation_domain' => 'BusetaSecurityBundle',
            ))
            ->add('apellidos', 'text', array(
                'required' => false,
            ))
            ->add('foto', new UploadResourcesType(), array(
                'required' => false,
                'label' => false,
            ))
            ->add('enabled',null,array(
                'required'=> false,
                'label' => 'usuario.data.enabled',
                'translation_domain' => 'BusetaSecurityBundle',
            ))
            ->add('pin','password',array(
                'required' => false,
                'label' => 'usuario.data.pin',
                'translation_domain' => 'BusetaSecurityBundle',
            ))
            ->add('roles','choice',array(
                'choices' => array(
                    'ROLE_SUPER_ADMIN' => 'Super Admin',
                    'ROLE_ADMINISTRADOR' => 'Administrador',
                    'ROLE_USER' => 'Usuario',
                    //'ROLE_ALLOWED_TO_SWITCH'=> 'ALLOWED TO SWITCH',
                ),
                'multiple' => true,
                'expanded' => false,
                'label' => 'usuario.data.roles',
                'translation_domain' => 'BusetaSecurityBundle',
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\SecurityBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'security_user_profile_type';
    }
}
