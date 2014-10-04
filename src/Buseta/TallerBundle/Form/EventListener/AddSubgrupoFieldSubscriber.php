<?php

namespace Buseta\TallerBundle\Form\EventListener;

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
            FormEvents::PRE_SUBMIT     => 'preBind'
        );
    }

    private function addSubgrupoForm($form, $subgrupo, $grupo)
    {
        $form->add('subgrupos','entity', array(
            'class'         => 'BusetaNomencladorBundle:Subgrupo',
            'empty_value'   => '---Seleccione un subgrupo---',
            'auto_initialize' => false,
            'data'          => $subgrupo,
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) use ($grupo) {
                    $qb = $repository->createQueryBuilder('subgrupos')
                        ->innerJoin('subgrupos.grupo', 'grupos');
                    if($grupo instanceof Grupo){
                        $qb->where('grupos = :grupos')
                            ->setParameter('grupos', $grupo);
                    }elseif(is_numeric($grupo)){
                        $qb->where('grupos.id = :grupos')
                            ->setParameter('grupos', $grupo);
                    }else{
                        $qb->where('grupos.valor = :grupos')
                            ->setParameter('grupos', null);
                    }

                    return $qb;
                }
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        //$province = ($data->city) ? $data->city->getSubgrupo() : null ;
        $subgrupo = ($data->getSubgrupos()) ? $data->getSubgrupos() : null ;
        $grupo = ($subgrupo) ? $subgrupo->getGrupo() : null ;
        $this->addSubgrupoForm($form, $subgrupo, $grupo);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $subgrupo = array_key_exists('subgrupos', $data) ? $data['subgrupos'] : null;
        $grupo = array_key_exists('grupos', $data) ? $data['grupos'] : null;
        $this->addSubgrupoForm($form, $subgrupo, $grupo);
    }
}