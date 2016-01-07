<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Event\FilterInventarioFisicoEvent;
use Buseta\BodegaBundle\Event\InventarioFisicoEvents;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Buseta\BodegaBundle\Entity\InventarioFisico;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;

/**
 * Class InventarioFisicoManager
 * @package Buseta\BodegaBundle\Manager\InventarioFisicoManager
 */
class InventarioFisicoManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;


    private $event_dispacher;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     *
     */
    function __construct(ObjectManager $em, Logger $logger, $event_dispacher)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->event_dispacher = $event_dispacher;
    }

    /**
     * Procesar InventarioFisico
     *
     * @param integer $id
     * @return bool
     * @throws NotValidStateException
     */
    public function procesar($id)
    {
        try {

            $inventarioFisico = $this->em->getRepository('BusetaBodegaBundle:InventarioFisico')->find($id);

            if (!$inventarioFisico) {
                //throw $this->createNotFoundException('Unable to find InventarioFisico entity.');
            }

            if ($inventarioFisico->getEstado() !== 'BO') {
                $this->logger->error(sprintf('El estado %s del Inventario Fisico con id %d no se corresponde con el estado previo a procesado(BO).',
                    $inventarioFisico->getEstado(),
                    $inventarioFisico->getId()
                ));
                throw new NotValidStateException();
            }

            // Change state Borrador(BO) to Procesado(PR)
            $eventDispatcher = $this->event_dispacher;
            $event = new FilterInventarioFisicoEvent($inventarioFisico);
            $eventDispatcher->dispatch(InventarioFisicoEvents::POS_PROCESS, $event);
            $resultado = $event->getReturnValue();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Inventario Fisico: %s',
                $e->getMessage()));

            return false;
        }

    }


    /**
     * Completar InventarioFisico
     *
     * @param integer $id
     * @return bool
     */
    public function completar($id)
    {
        try {

            /** @var \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico */

            $inventarioFisico = $this->em->getRepository('BusetaBodegaBundle:InventarioFisico')->find($id);

            if (!$inventarioFisico) {
                throw new NotFoundElementException('No se encontro la entidad InventarioFisico.');
            }

            $inventarioFisicoLineas = $this->em->getRepository('BusetaBodegaBundle:InventarioFisicoLinea')->findBy(array(
                'inventarioFisico' => $inventarioFisico,
            ));

            if ($inventarioFisicoLineas != null) {
                $eventDispatcher = $this->event_dispacher; //  get('event_dispatcher');
                foreach ($inventarioFisicoLineas as $linea) {
                    /** @var \Buseta\BodegaBundle\Entity\InventarioFisicoLinea $linea */
                    $event = new FilterBitacoraEvent($linea);
                    $eventDispatcher->dispatch(BitacoraEvents::INVENTORY_IN, $event);//I+
                    $resultado = $event->getReturnValue();
                }

                // Change state to 'CO'
                $event = new FilterInventarioFisicoEvent($inventarioFisico);
                $eventDispatcher->dispatch(InventarioFisicoEvents::POS_COMPLETE, $event);
                $resultado = $event->getReturnValue();
            }

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Inventario Fisico: %s',
                $e->getMessage()));
            return false;
        }

    }


    /**
     * CambiarEstado InventarioFisico
     *
     * @param InventarioFisico $inventarioFisico
     * @param string $estado
     * @return bool
     */
    public function cambiarestado($inventarioFisico, $estado)
    {
        try {

            if (($inventarioFisico == null) || ($estado == null)) {
                return false;
            }

            /** @var \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico */
            $inventarioFisico->setEstado($estado);
            $this->em->persist($inventarioFisico);
            $this->em->flush();

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al cambiar estado al Inventario Fisico: %s',
                $e->getMessage()));
            return false;
        }

    }

}
