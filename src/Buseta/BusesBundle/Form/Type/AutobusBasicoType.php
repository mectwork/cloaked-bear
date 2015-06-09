<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\EventListener\AddMarcaFieldSubscriber;
use Buseta\BusesBundle\Form\EventListener\AddModeloFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutobusBasicoType extends AbstractType
{
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
            $autobus = $event->getData();
            $form = $event->getForm();

            // este es un autobus nuevo
            if (!$autobus || null === $autobus->getId()) {
                $form
                    ->add('kilometraje', 'integer', array(
                        'required' => false,
                        'read_only' => true,
                        'attr' => array(
                            'class' => 'form-control',
                            'style' => 'width: 250px',
                        ),
                    ))
                    ->add('horas', 'integer', array(
                        'required' => false,
                        'read_only' => true,
                        'attr' => array(
                            'class' => 'form-control',
                            'style' => 'width: 250px',
                        ),
                    ));
            } else {
                $form
                    ->add('kilometraje', 'integer', array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'form-control',
                            'style' => 'width: 250px',
                        ),
                    ))
                    ->add('horas', 'integer', array(
                        'required' => false,
                        'attr' => array(
                            'class' => 'form-control',
                            'style' => 'width: 250px',
                        ),
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
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('numero', 'text', array(
                    'required' => true,
                    'label' => 'Número',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('numeroChasis', 'text', array(
                    'required' => true,
                    'label' => 'Número Chasis',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('numeroMotor', 'text', array(
                    'required' => true,
                    'label' => 'Número Motor',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('capacidadTanque', 'number', array(
                    'required' => true,
                    'label' => 'Capacidad Tanque',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('pesoTara', 'integer', array(
                    'required' => true,
                    'label' => 'Peso Tara',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('pesoBruto', 'integer', array(
                    'required' => true,
                    'label' => 'Peso Bruto',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('numeroPlazas', 'integer', array(
                    'required' => true,
                    'label' => 'Número Plazas',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('numeroCilindros', 'integer', array(
                    'required' => true,
                    'label' => 'Número Cilindros',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('cilindrada', 'integer', array(
                    'required' => true,
                    'label' => 'Cilindrada',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('potencia', 'integer', array(
                    'required' => true,
                    'label' => 'Potencia',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('validoHasta', 'date', array(
                    'widget' => 'single_text',
                    'format'  => 'dd/MM/yyyy',
                    'label' => 'Válido Hasta',
                    'attr'   => array(
                        'class' => 'form-control date',
                    )
                ))
            ->add('fechaRtv1', 'choice', array(
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                    'empty_value' => '---Seleccione---',
                    'choices' => array('Enero'=>'Enero',
                                       'Febrero' => 'Febrero',
                                       'Marzo' => 'Marzo',
                                       'Abril' => 'Abril',
                                       'Mayo' => 'Mayo',
                                       'Junio' => 'Junio',
                                       'Julio' => 'Julio',
                                       'Agosto' => 'Agosto',
                                       'Septiembre' => 'Septiembre',
                                       'Octubre' => 'Octubre',
                                       'Noviembre' => 'Noviembre',
                                       'Diciembre' => 'Diciembre',
                    ),
                    ))
            ->add('fechaRtv2', 'choice', array(
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                    'empty_value' => '---Seleccione---',
                    'choices' => array('Enero'=>'Enero',
                                       'Febrero' => 'Febrero',
                                       'Marzo' => 'Marzo',
                                       'Abril' => 'Abril',
                                       'Mayo' => 'Mayo',
                                       'Junio' => 'Junio',
                                       'Julio' => 'Julio',
                                       'Agosto' => 'Agosto',
                                       'Septiembre' => 'Septiembre',
                                       'Octubre' => 'Octubre',
                                       'Noviembre' => 'Noviembre',
                                       'Diciembre' => 'Diciembre',
                    ),
                ))
            ->add('fechaIngreso', 'date', array(
                    'widget' => 'single_text',
                    'label' => 'Fecha Ingreso',
                    'format'  => 'dd/MM/yyyy',
                    'attr'   => array(
                        'class' => 'form-control date',
                    ),
                ))
            ->add('estilo','entity',array(
                    'class' => 'BusetaNomencladorBundle:Estilo',
                    'empty_value' => '---Seleccione---',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('color', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:Color',
                    'empty_value' => '---Seleccione---',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('marcaMotor', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:MarcaMotor',
                    'label' => 'Marca Motor',
                    'empty_value' => '---Seleccione---',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('combustible', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:Combustible',
                    'empty_value' => '---Seleccione---',
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('rampas', 'textarea', array(
                    'required' => false,
                    'label' => ' ',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('barras', 'textarea', array(
                    'required' => false,
                    'label' => ' ',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('camaras', 'textarea', array(
                    'required' => false,
                    'label' => ' ',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('lectorCedulas', 'textarea', array(
                    'required' => false,
                    'label' => ' ',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('publicidad', 'textarea', array(
                    'required' => false,
                    'label' => ' ',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('gps', 'textarea', array(
                    'required' => false,
                    'label' => ' ',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('wifi', 'textarea', array(
                    'required' => false,
                    'label' => ' ',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            /*->add('archivo_adjunto','collection',array(
                    'type' => 'file',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ))*/
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Buseta\BusesBundle\Form\Model\AutobusBasicoModel',
                'method' => 'POST',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buses_autobus_basico';
    }
}
