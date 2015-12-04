<?php

namespace HatueySoft\SecurityBundle\Form\Type;


use HatueySoft\SecurityBundle\Form\DataTransformer\RoleNameTransformer;
use HatueySoft\SecurityBundle\Utils\ConfigurationReader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoleType extends AbstractType
{
    /**
     * @var \HatueySoft\SecurityBundle\Utils\ConfigurationReader
     */
    private $configurationReader;


    /**
     * @param ConfigurationReader $configurationReader
     */
    function __construct(ConfigurationReader $configurationReader)
    {
        $this->configurationReader = $configurationReader;
    }

    /**
     * @inheritdoc
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            $builder->create('role', 'text')
                ->addModelTransformer(new RoleNameTransformer())
        );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'addRolesChoices'));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'hatueysoft_security_role_type';
    }

    public function addRolesChoices(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $roles = $this->configurationReader->getRoleList();
        $rolesArray = array('ROLE_USER' => 'ROLE_USER');
        if (isset($data['role']) && $data['role'] !== null) {
            $role = $data['role'];

            foreach ($roles as $r) {
                if ($r !== $role) {
                    $rolesArray[$r] = $r;
                }
            }
        } else {
            foreach ($roles as $r) {
                $rolesArray[$r] = $r;
            }
        }

        $form
            ->add('rolesChoices', 'choice', array(
                'choices' => $rolesArray,
                'expanded' => true,
                'multiple' => true,
            ));
    }
}
