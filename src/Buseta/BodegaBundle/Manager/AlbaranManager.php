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
    function __construct(ObjectManager $em, Logger $logger,  EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->dispatcher =   $dispatcher;
    }

    /**
     * Procesar Albaran
     *
     * @param integer $id
     * @return bool
     * @throws NotValidStateException
     */
    public function procesar($id)
    {
        try {

            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                throw new NotFoundElementException('No se encontro la entidad Albaran.');
            }

            if ($albaran->getEstadoDocumento()!== 'BO') {
                $this->logger->error(sprintf('El estado %s del Albaran con id %d no se corresponde con el estado previo a procesado(PR).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                ));
                throw new NotValidStateException();
            }

            // Change state Borrador(BO) to Procesado(PR)
            $eventDispatcher = $this->dispatcher;
            $event = new FilterAlbaranEvent($albaran);
            $eventDispatcher->dispatch(AlbaranEvents::POS_PROCESS, $event);
            $resultado = $event->getReturnValue();

            return $resultado;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Albaran: %s', $e->getMessage()));

            return false;
        }

    }


    /**
     * Completar Albaran
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     * @return bool
     */
    public function completar(Albaran $albaran)
    {
        try {
            $albaranLineas =  $albaran->getAlbaranLineas();

            if ($albaranLineas !== null && count($albaranLineas) > 0) {
                foreach ($albaranLineas as $linea) {
                    /** @var \Buseta\BodegaBundle\Entity\AlbaranLinea $linea */
                    $event = new FilterBitacoraEvent($linea);
                    $this->dispatcher->dispatch(BitacoraEvents::VENDOR_RECEIPTS, $event);
                    $resultado = $event->getReturnValue();
                }

                // Change state to 'CO'
                $event = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(AlbaranEvents::POS_COMPLETE, $event);
                $resultado = $event->getReturnValue();
            }

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Albaran: %s', $e->getMessage()));
            return false;
        }

    }


    /**
     * CambiarEstado Albaran
     *
     * @param Albaran $albaran
     * @param string $estado
     * @return bool
     */
    public function cambiarestado($albaran, $estado)
    {
        try {

            if (($albaran == null) || ($estado==null)) return false;

            /** @var \Buseta\BodegaBundle\Entity\Albaran $albaran */
            $albaran->setEstadoDocumento($estado);
            $this->em->persist($albaran);
            $this->em->flush();

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al cambiar estado al Albaran: %s', $e->getMessage()));
            return false;
        }

    }

}
