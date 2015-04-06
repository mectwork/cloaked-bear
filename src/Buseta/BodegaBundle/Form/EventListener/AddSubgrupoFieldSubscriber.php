<?php

namespace Buseta\BodegaBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\NomencladorBundle\Entity\Grupo;

class AddSubgrupoFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT     => 'preBind',
        );
    }

    private function addSubgrupoForm($form, $subgrupo = null, $grupo = null)
    {
        if ($grupo === null) {
            $form->add('subgrupo', 'choice', array(
                'choices' => array(),
                'empty_value'   => '---Seleccione subgrupo---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('subgrupo', 'entity', array(
                'class'         => 'BusetaNomencladorBundle:Subgrupo',
                'empty_value'   => '---Seleccione subgrupo---',
                'auto_initialize' => false,
                'data'          => $subgrupo,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($grupo) {
                        $qb = $repository->createQueryBuilder('subgrupo')
                            ->innerJoin('subgrupo.grupo', 'grupo');
                        if ($grupo instanceof Grupo) {
                            $qb->where('grupo = :grupo')
                                ->setParameter('grupo', $grupo);
                        } elseif (is_numeric($grupo)) {
                            $qb->where('grupo.id = :grupo')
                                ->setParameter('grupo', $grupo);
                        } else {
                            $qb->where('grupo.valor = :grupo')
                                ->setParameter('grupo', null);
                        }

                        return $qb;
                    },
            ));
        }
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null == $data) {
            $this->addSubgrupoForm($form);
        } else {
            $subgrupo = ($data->getSubgrupo()) ? $data->getSubgrupo() : null;
            $grupo = ($subgrupo) ? $subgrupo->getGrupo() : null;
            $this->addSubgrupoForm($form, $subgrupo, $grupo);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $subgrupo = array_key_exists('subgrupo', $data) ? $data['subgrupo'] : null;
        $grupo = array_key_exists('grupo', $data) ? $data['grupo'] : null;
        $this->addSubgrupoForm($form, $subgrupo, $grupo);
    }
}
