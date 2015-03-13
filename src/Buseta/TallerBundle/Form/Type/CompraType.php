<?php

namespace Buseta\TallerBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompraType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Container
     */
    private $serviceContainer;

    public function __construct(ObjectManager $em, Container $serviceContainer)
    {
        $this->em = $em;
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'preSetData'));
        $builder
            ->add('numero', 'text', array(
                    'required' => true,
                    'label'  => 'Número',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('numero_factura_proveedor', 'text', array(
                'required' => true,
                'label'  => 'Número factura de proveedor',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('orden_prioridad', 'choice', array(
                'required' => true,
                'translation_domain' => 'BusetaTallerBundle',
                'empty_value' => '---Seleccione prioridad---',
                'choices' => array(
                    'High' => 'prioridad.High',
                    'Medium' => 'prioridad.Medium',
                    'Low' => 'prioridad.Low',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('descripcion', 'textarea', array(
                    'required' => false,
                    'label'  => 'Descripción',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('fecha_pedido', 'date', array(
                'widget' => 'single_text',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('forma_pago', 'entity', array(
                'class' => 'BusetaNomencladorBundle:FormaPago',
                'label' => 'Forma de Pago',
                'empty_value' => '---Seleccione forma de pago---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('moneda', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Moneda',
                'empty_value' => '---Seleccione tipo de moneda---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('condiciones_pago', 'entity', array(
                'class' => 'BusetaTallerBundle:CondicionesPago',
                'empty_value' => '---Seleccione condiciones de pago---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('importe_libre_impuesto', 'text', array(
                    'required' => true,
                    'read_only' => true,
                    'label'  => 'Importe libre de impuesto',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('importe_con_impuesto', 'text', array(
                    'required' => true,
                    'read_only' => true,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('importe_general', 'text', array(
                    'required' => true,
                    'read_only' => true,
                    'label'  => 'Importe general',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('estado', 'choice', array(
                    'required' => true,
                    'empty_value' => '---Seleccione estado---',
                    'translation_domain' => 'BusetaTallerBundle',
                    'choices' => array(
                        '??' => 'estado.??',
                        'AP' => 'estado.AP',
                        'CH' => 'estado.CH',
                        'CL' => 'estado.CL',
                        'CO' => 'estado.CO',
                        'DR' => 'estado.DR',
                        'IN' => 'estado.IN',
                        'IP' => 'estado.IP',
                        'NA' => 'estado.NA',
                        'PE' => 'estado.PE',
                        'PO' => 'estado.PO',
                        'PR' => 'estado.PR',
                        'RE' => 'estado.RE',
                        'TE' => 'estado.TE',
                        'TR' => 'estado.TR',
                        'VO' => 'estado.VO',
                        'WP' => 'estado.WP',
                        'XX' => 'estado.XX',
                    ),
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('tercero', 'entity', array(
                    'class' => 'BusetaBodegaBundle:Tercero',
                    'query_builder' => function (EntityRepository $er) {
                            return $er->createQueryBuilder('t')
                                ->where('t.proveedor = true');
                        },
                    'empty_value' => '---Seleccione un proveedor---',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('lineas', 'collection', array(
                'type' => new LineaType(),
                'label'  => false,
                'required' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('mecanico_solicita', 'text', array(
                'required' => true,
                'label'  => 'Mecánico que solicita',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('centro_costo', 'entity', array(
                'class' => 'BusetaBusesBundle:Autobus',
                'label' => 'Centro de costo',
                'empty_value' => '---Seleccione centro de costo---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('precio_general', 'text', array(
                'required' => true,
                'read_only' => true,
                'label'  => 'Precio general',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\Compra',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'taller_compra';
    }

    public function preSetData(FormEvent $formEvent)
    {
        $form = $formEvent->getForm();

        //Compruebo que existe el consecutivo automatico de Compra
        //Si no existe captu$consecutivoCompraro la configuracion predeterminada,
        //Si existe obtengo el maximo valor de consecutivo de compra y le incremento en 1
        $results = $this->em->getRepository('BusetaTallerBundle:Compra')->consecutivoLast();

        $consecutivoCompra = $results ?
            $results['consecutivo_compra'] + 1 :
            $this->serviceContainer->getParameter('consecutivoCompra');

        $form->add('consecutivo_compra', 'text', array(
            'required' => true,
            'read_only' => true,
            'label'  => 'Consecutivo automático',
            'attr'   => array(
                'class' => 'form-control',
            ),
            'data' => $consecutivoCompra,
        ));
    }
}
