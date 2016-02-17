<?php

namespace Buseta\BodegaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\BodegaBundle\Form\Model\NecesidadMaterialModel;

class NecesidadMaterialType extends AbstractType
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
        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('numero_documento', 'text', array(
                'required' => false,
                'label'  => 'Nro.Documento',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))//
            ->add('numero_referencia', 'text', array(
                'required' => false,
                'label'  => 'Nro.Referencia',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tercero', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('t');
                    return $qb
                        ->select('t, proveedor')
                        ->innerJoin('t.proveedor', 'proveedor')
                        ->where($qb->expr()->isNotNull('proveedor'))
                        ->orderBy('t.nombres', 'ASC');
                },
                'empty_value' => '---Seleccione---',
                'required' => true,
                'label' => 'Nombre del Proveedor',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fecha_pedido', 'date', array(
                'widget' => 'single_text',
                'required' => false,
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'label' => 'Bodega',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('moneda', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Moneda',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('forma_pago', 'entity', array(
                'class' => 'BusetaNomencladorBundle:FormaPago',
                'label' => 'Forma de Pago',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('condiciones_pago', 'entity', array(
                'class' => 'BusetaTallerBundle:CondicionesPago',
                'label' => 'Condiciones de Pago',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            /*->add('estado_documento', 'choice', array(
                'required' => false,
                'read_only' => true,
                'empty_value' => '---Seleccione---',
                'translation_domain' => 'BusetaTallerBundle',
                'choices' => array(
                    'CO' => 'estado.CO',
                    'BO' => 'estado.BO',
                    'PR' => 'estado.PR',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))*/
            ->add('descuento', 'number', array(
                'required'  => false,
                'label'     => 'Descuento compra',
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('impuesto', 'entity', array(
                'class'         => 'BusetaTallerBundle:Impuesto',
                'empty_value'   => '---Seleccione---',
                'required'      => false,
                'label'         => 'Impuesto compra',
                'attr'          => array(
                    'class' => 'form-control',
                )
            ))
            ->add('importeCompra', 'number', array(
                'required' => false,
                'label' => 'Importe compra',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('importe_total_lineas', 'number', array(
                'required' => false,
                'label'  => 'Importe total líneas',
                'read_only' => true,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))

            ->add('importeDescuento', 'number', array(
                'required' => false,
                'read_only' => true,
                'label'  => 'Importe descuento',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('importeImpuesto', 'number', array(
                'required' => false,
                'read_only' => true,
                'label'  => 'Importe impuesto',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('importe_total', 'number', array(
                'required' => false,
                'read_only' => true,
                'label'  => 'Importe total',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('observaciones', 'textarea', array(
                'required' => false,
                'label'  => 'Observaciones',
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
            'data_class' => 'Buseta\BodegaBundle\Form\Model\NecesidadMaterialModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bodega_necesidad_material';
    }

}
