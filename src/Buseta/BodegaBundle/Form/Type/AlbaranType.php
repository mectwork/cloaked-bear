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
            ->add('numero_documento', 'text', array(
                    'required' => true,
                    'label'  => 'Nro.Documento',
                    'attr'   => array(
                        'class' => 'form-control',
                    )
                ))//
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
        return 'bodega_pedido_compra';
    }
}
