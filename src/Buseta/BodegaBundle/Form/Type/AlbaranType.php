<?php

namespace Buseta\BodegaBundle\Form\Type;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Entity\NecesidadMaterial;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Util\ClassUtils;


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
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'preSetData'));
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
            ->add('almacen', 'entity', array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'placeholder' => '---Seleccione---',
                'label' => 'Bodega',
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
                        ->where($qb->expr()->isNotNull('proveedor.id'))
                        ->orderBy('t.nombres', 'ASC')
                    ;
                },
                'placeholder' => '---Seleccione---',
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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

    public function preSetData(FormEvent $formEvent)
    {

        $data = $formEvent->getData();
        $form = $formEvent->getForm();
        $sequenceManager = $this->serviceContainer->get('hatuey_soft.sequence.manager');

        if ($sequenceManager->hasSequence('Buseta\BodegaBundle\Entity\Albaran')) {
            if ( $data->getNumeroDocumento() ) {
                $secuencia = $data->getNumeroDocumento();
            } else {
                $sequenceManager = $this->serviceContainer->get('hatuey_soft.sequence.manager');
                $secuencia = $sequenceManager->getNextValue('orden_entrada_seq');
            }

            $form->add('numeroDocumento', 'text', array(
                'required' => true,
                'read_only' => true,
                'label'  => 'Nro.Documento',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'data' => $secuencia,
            ));

        }  else {
            $form->add('numeroDocumento', 'text', array(
                'required' => true,
                'label'  => 'Nro.Documento',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ));

        }


    }
}
