<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\EventListener\AddMarcaFieldSubscriber;
use Buseta\BusesBundle\Form\EventListener\AddModeloFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutobusType extends AbstractType
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
            } else {
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
            }
        });

        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('imagen_frontal', 'file', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                        'style' => 'width: 250px',
                    ),
                ))
            ->add('imagen_lateral_d', 'file', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('imagen_lateral_i', 'file', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('imagen_trasera', 'file', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('matricula', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('numero', 'text', array(
                'required' => true,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('marca_cajacambio', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('tipo_cajacambio', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('aceitecajacambios', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:AceiteCajaCambios',
                    'empty_value' => '---Seleccione---',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('aceitehidraulico', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:AceiteHidraulico',
                    'empty_value' => '---Seleccione---',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('aceitemotor', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:AceiteMotor',
                    'empty_value' => '---Seleccione---',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('aceitetransmision', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:AceiteTransmision',
                    'empty_value' => '---Seleccione---',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('carter_capacidadlitros', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('bateria_1', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('bateria_2', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('filtro_aceite', new FiltroAceiteType())

            ->add('filtro_diesel', new FiltroDieselType())

            ->add('filtro_hidraulico', new FiltroHidraulicoType())

            ->add('filtro_caja', new FiltroCajaType())

            ->add('filtro_transmision', new FiltroTransmisionType())

            ->add('filtro_agua', new FiltroAguaType())

            ->add('numero_chasis', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('numero_motor', 'text', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('capacidad_tanque', 'number', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('valor_unidad', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('numero_unidad', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('anno', 'number', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('peso_tara', 'number', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('peso_bruto', 'number', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('numero_plazas', 'number', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('numero_cilindros', 'number', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('cilindrada', 'number', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('potencia', 'number', array(
                    'required' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('valido_hasta', 'date', array(
                    'widget' => 'single_text',
                    'format'  => 'dd/MM/yyyy',
                    'attr'   => array(
                        'class' => 'form-control date',
                    )
                ))
            ->add('fecha_rtv_1', 'choice', array(
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
            ->add('fecha_rtv_2', 'choice', array(
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
            ->add('fecha_ingreso', 'date', array(
                    'widget' => 'single_text',
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
            ->add('marca_motor', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:MarcaMotor',
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
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('barras', 'textarea', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('camaras', 'textarea', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('lector_cedulas', 'textarea', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('publicidad', 'textarea', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('gps', 'textarea', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('wifi', 'textarea', array(
                    'required' => false,
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
                'data_class' => 'Buseta\BusesBundle\Form\Model\AutobusModel',
                'method' => 'POST',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_databundle_autobus';
    }
}
