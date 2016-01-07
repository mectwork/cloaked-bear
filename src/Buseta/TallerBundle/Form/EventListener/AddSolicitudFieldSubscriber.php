<?php

namespace Buseta\TallerBundle\Form\EventListener;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class AddSolicitudFieldSubscriber implements EventSubscriberInterface
{

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        );
    }

    private function addReporteForm(FormInterface $form, $reporte = null)
    {
        $form->add('reporte', 'entity', array(
            'class' => 'BusetaTallerBundle:Reporte',
            //Obtiene todos los reportes que no tengan asociados un diagnostico
            //para no asociarle dos diagnosticos a una misma solicitud
            'query_builder' => function (EntityRepository $er) use ($reporte) {
                $qb = $er->createQueryBuilder('r');
                $qb
                    ->leftJoin('r.diagnostico', 'd')
                ;
                if ($reporte !== null) {
                    $qb->andWhere(
                        $qb->expr()->orX(
                            $qb->expr()->isNull('d'),
                            $qb->expr()->eq('r.id', ':id')
                        )
                    )->setParameter('id', $reporte);
                } else {
                    $qb->andWhere($qb->expr()->isNull('d'));
                }

                return $qb;
            },
            'empty_value' => '---Seleccione---',
            'label' => 'Solicitud',
            'required' => false,
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if ($data === null) {
            $this->addReporteForm($form);
        }

        $accessor = PropertyAccess::createPropertyAccessor();
        $id = $accessor->getValue($data, 'id');
        $reporte = $accessor->getValue($data, 'reporte');

        if ($id && $reporte) {
            $form->add('reporte', 'entity', array(
                'read_only' => true,
                'class' => 'BusetaTallerBundle:Reporte',
                //Obtiene todos los reportes que no tengan asociados un diagnostico
                //para no asociarle dos diagnosticos a una misma solicitud
                'query_builder' => function (EntityRepository $er) use ($reporte) {
                    $qb = $er->createQueryBuilder('r');
                    $qb
                        ->andWhere('r.id = :id')
                        ->setParameter('id', $reporte)
                    ;
                    return $qb;
                },
                'label' => 'Solicitud',
                'required' => true,
            ));
        } else {
            $this->addReporteForm($form);
        }
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        $reporte = array_key_exists('reporte', $data) ? $data['reporte'] : null;
        $this->addReporteForm($form, $reporte);
    }
}
