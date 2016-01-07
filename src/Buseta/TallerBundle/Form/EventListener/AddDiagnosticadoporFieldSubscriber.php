<?php

namespace Buseta\TallerBundle\Form\EventListener;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class AddDiagnosticadoporFieldSubscriber implements EventSubscriberInterface
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

    private function addDiagnosticadoporForm(FormInterface $form, $diagnostico = null)
    {
        //Aqui creo el form de municipio
        $form->add('diagnosticadoPor', 'entity', array(
            'class'         => 'BusetaBodegaBundle:Tercero',
            'auto_initialize' => false,
            'empty_value'   => '.:Seleccione:.',
            //Con el query builder obtengo el repositorio de la provincia
            'query_builder' => function (EntityRepository $re) use ($diagnostico) {
               /* $qb = $re->createQueryBuilder('diag');
                $query = $qb->where($qb->expr()->eq(true,true));
                $query->select('diag.autobus')
                    ->from('Diagnostico','d')
                    ->where($qb->expr()->eq('diag.id',':id'))
                    ->setParameter('id', $diagnostico);




                try {
                    return $query->getQuery();
                } catch (NoResultException $e) {
                    return array();
                }*/
            },
        ));

    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        $propertyAccessor = new PropertyAccessor();

        if ($data === null || $propertyAccessor->getValue($data, 'diagnostico') === null) {
            $form->add('diagnosticadoPor', 'choice', array(
                'choices' => array(),
                'empty_value' => '......:Seleccione un diagnostico:......',
                'disabled' => 'true',
                'required' => false,
            ));
        } else {

            $diagnostico = $propertyAccessor->getValue($data, 'diagnostico');
            $this->addDiagnosticadoporForm($form, $diagnostico);
        }
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        if ($data === null || $data['diagnostico'] === null) {
            return;
        } else {

            $diagnostico = $data['diagnostico'];
            $this->addDiagnosticadoporForm($form, $diagnostico);
        }
    }
}
