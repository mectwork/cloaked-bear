<?php

namespace Buseta\BodegaBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Buseta\BodegaBundle\Form\Type\AlbaranLineaType;

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

    function __construct(ObjectManager $em, Container $serviceContainer)
    {
        $this->em = $em;
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroReferencia', 'text', array(
                    'required' => false,
                    'label'  => 'Nro.Referencia',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))
            ->add('consecutivoCompra', 'text', array(
                'required' => true,
                'label'  => 'Nro.Documento',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('almacen','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('tercero','entity',array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('t')
                        ->where('t.proveedor = true');
                },
                'empty_value' => '---Seleccione un proveedor---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaMovimiento','date',array(
                'widget' => 'single_text',
                'label'  => 'Fecha Movimiento',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaContable','date',array(
                'widget' => 'single_text',
                'label'  => 'Fecha Contable',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('estadoDocumento', 'choice', array(
                'required' => true,
                'empty_value' => '---Seleccione estado documento---',
                'translation_domain'=> 'BusetaTallerBundle',
                'choices' => array(
                    'CO' => 'estado.CO',
                    'BO' => 'estado.BO',
                    'PR' => 'estado.PR',
                ),
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('albaranLinea','collection',array(
                'type' => new AlbaranLineaType(),
                'label'  => false,
                'required' => false,
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
            'data_class' => 'Buseta\BodegaBundle\Entity\Albaran'
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
