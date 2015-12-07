<?php

namespace Buseta\CombustibleBundle\Form\Type;

use Buseta\CombustibleBundle\Form\Type\ChoferInServicioCombustibleType;
use Buseta\CoreBundle\Managers\CambioHoraSistemaManager;
use Buseta\CoreBundle\Managers\FechaSistemaManager;
use Buseta\CoreBundle\Twig\FechaSistemaExtension;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class ServicioCombustibleType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Container
     */
    private $serviceContainer;

    /**
     * @var FechaSistemaManager
     */
    private $fechaSistema;

    /**
     * @var CambioHoraSistemaManager
     */
    private $horaSistema;

    public function __construct(ObjectManager $em, Container $serviceContainer, FechaSistemaManager $fechaSistema, CambioHoraSistemaManager $horaSistema)
    {
        $this->em = $em;
        $this->serviceContainer = $serviceContainer;
        $this->fechaSistema = $fechaSistema;
        $this->horaSistema = $horaSistema;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chofer',new ChoferInServicioCombustibleType(),array(
                    'label' => ' ',
                )
            )

            ->add('combustible','entity',array(
                'class' => 'BusetaCombustibleBundle:ConfiguracionCombustible',
                'empty_value' => '---Seleccione---',
                'label' => 'Nomenclador de Combustible',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('cantidadLibros', 'integer', array(
                'required' => true,
                'label' => 'Cantidad de Libros',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            $hora = $this->horaSistema->getHoraCambio()->format('H:i:s');

            $fechaActualInicial = $this->fechaSistema->getFechaSistema();
            $fechaActualInicial->setTime($hora[0],$hora[1],$hora[2]);

            $fechaActualFinal = $this->fechaSistema->getFechaSistema();
            $fechaActualFinal->modify('+1 days');

            $fechaSistema = $this->fechaSistema->getFechaSistema();

            $form->add('vehiculo', 'entity', array(
                'class' => 'BusetaBusesBundle:Vehiculo',
                'query_builder' => function(EntityRepository $repository) use ($fechaActualInicial,$fechaActualFinal,$fechaSistema) {
                    $qb = $repository->createQueryBuilder('vehiculo');
                    $qb
                        ->where('NOT EXISTS(SELECT ln FROM BusetaCombustibleBundle:ListaNegraCombustible ln INNER JOIN ln.autobus a WHERE a=vehiculo AND ln.fechaInicio<=:fechaActual AND ln.fechaFinal>=:fechaActual )')
                        ->andWhere('NOT EXISTS(SELECT s FROM BusetaCombustibleBundle:ServicioCombustible s INNER JOIN s.vehiculo v WHERE v=vehiculo AND s.created>:fechaActualInicial AND s.created<:fechaActualFinal)')
                        ->orderBy('vehiculo.matricula')
                        ->setParameter('fechaActual', $fechaSistema)
                        ->setParameter('fechaActualInicial', $fechaActualInicial)
                        ->setParameter('fechaActualFinal', $fechaActualFinal)
                    ;
                    return $qb;
                },

                'empty_value' => '---Seleccione---',
                'label' => 'Vehículo',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ));

            /*$form->add('autobus', 'entity', array(
                'class' => 'BusetaBusesBundle:Autobus',
                'query_builder' => function(EntityRepository $repository) use ($fechaActualInicial,$fechaActualFinal) {
                    $qb = $repository->createQueryBuilder('bus');
                    $qb
                        ->where('NOT EXISTS(SELECT ln FROM BusetaCombustibleBundle:ListaNegraCombustible ln INNER JOIN ln.autobus a WHERE a=bus AND ln.fechaInicio<=:fechaActual AND ln.fechaFinal>=:fechaActual )')
                        ->andWhere('NOT EXISTS(SELECT d FROM BusetaCombustibleBundle:ServicioCombustible d INNER JOIN d.autobus au WHERE au=bus AND d.created>:fechaActualInicial AND d.created<:fechaActualFinal)')
                        ->orderBy('bus.matricula')
                        ->setParameter('fechaActual', new \DateTime())
                        ->setParameter('fechaActualInicial', $fechaActualInicial)
                        ->setParameter('fechaActualFinal', $fechaActualFinal)
                    ;
                    return $qb;
                },

                'empty_value' => '---Seleccione---',
                'label' => 'Autobús',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ));*/

        });

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\CombustibleBundle\Form\Model\ServicioCombustibleModel'
        ));
    }

    public function getName()
    {
        return 'combustible_servicio_combustible';
    }
}
