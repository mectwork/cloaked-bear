<?php

namespace Buseta\BodegaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlbaranType extends AbstractType
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
            ->add('numeroReferencia', 'text', array(
                    'required' => false,
                    'label'  => 'Nro.Referencia',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('consecutivoCompra', 'text', array(
                'required' => false,
                'label'  => 'Nro.Documento',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione---',
                'label' => 'Almacén',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tercero', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'label' => 'Nombre del Proveedor',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('t');
                    return $qb->join('t.proveedor', 'proveedor')
                        ->where($qb->expr()->isNotNull('proveedor'));
                },
                'empty_value' => '---Seleccione---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaMovimiento', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Movimiento',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaContable', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Fecha Contable',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('estadoDocumento', 'choice', array(
                'required' => false,
                'read_only' => true,
                'label' => 'Estado del Documento',
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
            ))
            ->add('albaranLinea', 'collection', array(
                'type' => new AlbaranLineaType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Form\Model\AlbaranModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bodega_albaran_type';
    }
}
