<?php

namespace HatueySoft\SecurityBundle\Form\Type;

use HatueySoft\SecurityBundle\Utils\ConfigurationReader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @var \HatueySoft\SecurityBundle\Utils\ConfigurationReader
     */
    private $configurationReader;

    public function __construct(ConfigurationReader $configurationReader)
    {
        $this->configurationReader = $configurationReader;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetDataUsername'));
        $builder
            ->add('nombres', 'text', array(
                    'label' => 'Nombres',
                    'required' => false,
                    'translation_domain' => 'HatueySoftSecurityBundle',
                ))
            ->add('apellidos', 'text', array(
                'label' => 'Apellidos',
                'required' => false,
                'translation_domain' => 'HatueySoftSecurityBundle',
            ))
            ->add('email', 'email', array(
                    'label' => 'form.email',
                    'translation_domain' => 'FOSUserBundle',
                ))
            ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array(
                        'label' => 'form.password',
                        'attr' => array(
                            'class' => 'form-control',
                        )),
                    'second_options' => array(
                        'label' => 'form.password_confirmation',
                        'attr' => array(
                            'class' => 'form-control',
                        )),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))

            ->add('grupobuses', 'entity', array(
                'class' => 'BusetaBusesBundle:GrupoBuses',
                'label' => 'Grupo Buses',
                'multiple' => true,
                ));

            $builder
                ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetDataRoles'));
            /*->add('groups', null, array(
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))*/
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueySoft\SecurityBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueysoft_security_usuario_type';
    }

    public function onPreSetDataUsername(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        if(!$user || null === $user->getId()) {
            $form
                ->add('username', null, array(
                        'label' => 'form.username',
                        'translation_domain' => 'FOSUserBundle',
                    ));
        } else {
            $form
                ->add('username', null, array(
                        'label' => 'form.username',
                        'translation_domain' => 'FOSUserBundle',
                        'attr' => array(
                            'readonly' => true,
                        )
                    ));

        }
    }

    public function onPreSetDataRoles(FormEvent $event)
    {
        $form = $event->getForm();
        $choices = array();
        foreach($this->configurationReader->getRoleList() as $role) {
            $choices[$role] = $role;
        }

        $form->add('roles','choice', array(
                'multiple' => true,
                'choices' => $choices,
                'required' => false,
            ));

    }
}
