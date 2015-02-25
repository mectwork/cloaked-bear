<?php

namespace Buseta\TallerBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
use Buseta\NomencladorBundle\Entity\Subgrupo;

class AddTareaMantenimientoFieldSubscriber implements EventSubscriberInterface
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

    private function addTareaMantenimientoForm($form, $tarea = null, $subgrupo = null)
    {
        if($subgrupo === null) {
            $form->add('tarea','choice',array(
                'choices' => array(),
                'empty_value'   => '---Seleccione tarea---',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
        } else {
            $form->add('tarea','entity', array(
                'class'         => 'BusetaTallerBundle:TareaMantenimiento',
                'empty_value'   => '---Seleccione tarea---',
                'auto_initialize' => false,
                'data'          => $tarea,
                'attr' => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) use ($subgrupo) {
                        $qb = $repository->createQueryBuilder('tarea')
                            ->innerJoin('tarea.subgrupos', 'subgrupos');
                        if($subgrupo instanceof Subgrupo){
                            $qb->where('subgrupos = :subgrupos')
                                ->setParameter('subgrupos', $subgrupo);
                        }elseif(is_numeric($subgrupo)){
                            $qb->where('subgrupos.id = :subgrupos')
                                ->setParameter('subgrupos', $subgrupo);
                        }else{
                            $qb->where('subgrupos.valor = :subgrupos')
                                ->setParameter('subgrupos', null);
                        }

                        return $qb;
                    }
            ));
        }
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null == $data) {
            $this->addTareaMantenimientoForm($form);
        } else {
            $tarea = ($data->getTarea()) ? $data->getTarea() : null ;
            $subgrupo = ($tarea) ? $tarea->getSubgrupos() : null ;
            $this->addTareaMantenimientoForm($form, $tarea, $subgrupo);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $tarea = array_key_exists('tarea', $data) ? $data['tarea'] : null;
        $subgrupo = array_key_exists('subgrupos', $data) ? $data['subgrupos'] : null;
        $this->addTareaMantenimientoForm($form, $tarea, $subgrupo);
    }
}