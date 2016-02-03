<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\EventListener\AddMarcaFieldSubscriber;
use Buseta\BusesBundle\Form\EventListener\AddModeloFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class VehiculoType extends AbstractType
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * Constructor
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $modelo = new AddModeloFieldSubscriber($objeto);
        $builder->addEventSubscriber($modelo);
        $marca = new AddMarcaFieldSubscriber($objeto);
        $builder->addEventSubscriber($marca);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $autobus    = $event->getData();
            $form       = $event->getForm();

            if ($autobus && null !== $autobus->getId() || $this->authorizationChecker->isGranted('ROLE_ADMIN')) {
                $form
                    ->add('kilometraje', 'integer', array(
                        'required' => false,
                    ))
                    ->add('horas', 'integer', array(
                        'required' => false,
                    ));
            }
        });

        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('matricula', 'text', array(
                'required' => true,
                'label' => 'Matrícula',
            ))
            ->add('numero', 'text', array(
                'required' => true,
                'label' => 'Número',
            ))
            ->add('capacidadTanque', 'number', array(
                'required' => true,
                'label' => 'Capacidad Tanque',
            ))

            ->add('numeroPlazas', 'integer', array(
                'required' => true,
                'label' => 'Número Plazas',
            ))
            ->add('numeroCilindros', 'integer', array(
                'required' => true,
                'label' => 'Número Cilindros',
            ))
            ->add('cilindrada', 'integer', array(
                'required' => true,
                'label' => 'Cilindrada',
            ))
            ->add('potencia', 'integer', array(
                'required' => true,
                'label' => 'Potencia',
            ))

            ->add('estilo','entity',array(
                'class' => 'BusetaNomencladorBundle:Estilo',
                'placeholder' => '---Seleccione---',
            ))
            ->add('color', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Color',
                'placeholder' => '---Seleccione---',
            ))
            ->add('marcaMotor', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:MarcaMotor',
                    'label' => 'Marca de Motor',
                    'placeholder' => '---Seleccione---',
                ))
            ->add('combustible', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Combustible',
                'placeholder' => '---Seleccione---',
            ))
            ->add('marcaCajacambio', 'text', array(
                'required' => false,
                'label' => 'Marca de Caja Cambios',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tipoCajacambio', 'text', array(
                'required' => false,
                'label' => 'Tipo de Caja Cambios',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('anno', 'number', array(
                'required' => false,
                'label' => 'Año',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Buseta\BusesBundle\Form\Model\VehiculoModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buses_vehiculo';
    }
}
