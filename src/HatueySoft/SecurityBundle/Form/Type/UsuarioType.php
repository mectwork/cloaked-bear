<?php

namespace HatueySoft\SecurityBundle\Form\Type;

use HatueySoft\SecurityBundle\Utils\ConfigurationReader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('nombres', 'text', array(
                'label' => 'usuario.data.nombres',
                'translation_domain' => 'HatueySoftSecurityBundle',
            ))
            ->add('apellidos', 'text', array(
                'label' => 'usuario.data.apellidos',
                'required' => false,
                'translation_domain' => 'HatueySoftSecurityBundle',
            ))
            ->add('email', 'email', array(
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle',
            ))
            ->add('pin', 'text', array (
                'required' => false,
                'label' => 'usuario.data.pin',
                'translation_domain' => 'HatueySoftSecurityBundle',
            ))
            ->add('grupobuses', 'entity', array(
                'required' => false,
                'class' => 'BusetaBusesBundle:GrupoBuses',
                'label' => 'usuario.data.grupoBuses',
                'translation_domain' => 'HatueySoftSecurityBundle',
                'multiple' => true,
                ));
        /*->add('groups', null, array(
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))*/

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetDataUsername'));
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetDataRoles'));
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $data = $event->getData();
                $form = $event->getForm();

                $options = array(
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
                );

                if ($data->getId() !== null) {
                    $options['required'] = false;
                }

                $form->add('plainPassword', 'repeated', $options);
            });
    }

    /**
     * @param FormEvent $event
     */
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

    /**
     * @param FormEvent $event
     */
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

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HatueySoft\SecurityBundle\Form\Model\UserModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hatueysoft_security_usuario_type';
    }
}
