<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Event\AlbaranEvents;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Buseta\BodegaBundle\Event\FilterAlbaranEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AlbaranManager
 * @package Buseta\BodegaBundle\Manager
 */
class AlbaranManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param EventDispatcherInterface $dispatcher
     */
    function __construct(ObjectManager $em, Logger $logger, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->dispatcher = $dispatcher;
    }


    /**
     * @param $id
     * @return bool|string
     */
    public function procesar($id)
    {
        try {

            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                throw new NotFoundElementException('No se encontro la entidad Albaran.');
            }

            if ($albaran->getEstadoDocumento() !== 'BO') {
                $this->logger->error(sprintf('El estado %s del Albaran con id %d no se corresponde con el estado previo a procesado(PR).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                ));
                throw new NotValidStateException();
            }

            // Change state Borrador(BO) to Procesado(PR)
            $event = new FilterAlbaranEvent($albaran);
            $this->dispatcher->dispatch(AlbaranEvents::POS_PROCESS, $event);
            $result = $event->getReturnValue();
            if ($result !== true) {
                //borramos los cambios en el entity manager
                $this->em->clear();
                return $error = $result;
            }

            $this->em->flush();
            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Albaran: %s', $e->getMessage()));
            return 'Ha ocurrido un error al procesar el Albaran';
        }

    }

    /**
     * @param $id
     * @return bool|string
     */
    public function completar($id)
    {
        /** @var \Buseta\BodegaBundle\Entity\Albaran $albaran */
        /** @var \Buseta\BodegaBundle\Entity\AlbaranLinea $lineas */
        try {

            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                throw new NotFoundElementException('No se encontro la entidad Albaran.');
            }

            $albaranLineas = $albaran->getAlbaranLineas();

            if ($albaranLineas !== null && count($albaranLineas) > 0) {
                foreach ($albaranLineas as $linea) {
                    /** @var \Buseta\BodegaBundle\Entity\AlbaranLinea $linea */
                    $event = new FilterBitacoraEvent($linea);
                    $this->dispatcher->dispatch(BitacoraEvents::VENDOR_RECEIPTS, $event);
                    $result = $event->getReturnValue();
                    if ($result !== true) {
                        //borramos los cambios en el entity manager
                        $this->em->clear();
                        return $error = $result;
                    }
                }

                // Change state to 'CO'
                $event = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(AlbaranEvents::POS_COMPLETE, $event);
                $result = $event->getReturnValue();
                if ($result !== true) {
                    //borramos los cambios en el entity manager
                    $this->em->clear();
                    return $error = $result;
                }
            } else {
                return $error = 'La Orden de Entrega debe tener al menos una linea';
            }

            //finalmente le damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales yel cambio de estado
            //es el unico flush que se hace.
            $this->em->flush();
            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar la Orden de Entrega: %s',
                $e->getMessage()));
            $this->em->clear();
            return $error = 'Ha ocurrido un error al completar la Orden de Entrega';
        }

    }

    /**
     * @param $albaran
     * @param $estado
     * @return bool|string
     */
    public function cambiarestado($albaran, $estado)
    {
        try {

            if (($albaran === null) || ($estado === null)) {
                return 'El albaran no puede ser vacio';
            }

            /** @var \Buseta\BodegaBundle\Entity\Albaran $albaran */
            $albaran->setEstadoDocumento($estado);
            $this->em->persist($albaran);

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al cambiar estado al Albaran: %s', $e->getMessage()));
            return 'Ha ocurrido un error al cambiar estado al Albaran';
        }

    }

}
