<?php

namespace HatueySoft\MenuBundle\Form\Type;


use HatueySoft\SecurityBundle\Utils\ConfigurationReader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\Tests\OptionsResolverTest;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class MenuNodeType extends AbstractType
{
    private $configurationReader;

    function __construct(ConfigurationReader $configurationReader)
    {
        $this->configurationReader = $configurationReader;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $roles = $this->configurationReader->getRoleList();
        $rolesChoices = array();
        foreach ($roles as $rol) {
            $rolesChoices[$rol] = $rol;
        }

        $parent = $options['parent'];
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $formEvent) use ($parent) {
            $form = $formEvent->getForm();
            $data = $formEvent->getData();

            $accesor = PropertyAccess::createPropertyAccessor();
            $id = $accesor->getValue($data, 'id');
            if (($parent !== null && $parent === 'menu') || ($id !== null && ($split = explode('_', $id)) && count($split) == 2)) {
                $form->add('name', 'text');
            }
        });

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $formEvent) {
            $form = $formEvent->getForm();
            $data = $formEvent->getData();

            $accesor = PropertyAccess::createPropertyAccessor();
            $id = $accesor->getValue($data, 'id');
            if ($id !== null) {
                $form->add('applyInChain', 'checkbox');
            }
        });

        $builder
            ->add('label')
            ->add('route')
            ->add('roles', 'choice', array(
                'multiple' => true,
                'choices' => $rolesChoices,
            ))
            ->add('type', 'choice', array(
                'empty_value' => '.:Seleccione:.',
                'choices' => array(
                    'folder' => 'folder',
                    'item'   => 'item'
                )
            ))
            ->add('attributes', 'collection', array(
                'type' => new MenuNodeAttributeType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('parent'));
        $resolver->setDefaults(array(
            'data_class' => 'HatueySoft\MenuBundle\Model\MenuNode',
            'parent' => null,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'hatueysoft_menu_node_type';
    }

}
