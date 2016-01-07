<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\BusetaBodegaBitacoraEvents;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;

/**
 * Class SalidaBodegaManager
 * @package Buseta\BodegaBundle\Manager\SalidaBodega
 */
class SalidaBodegaManager
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
    function __construct(ObjectManager $em, Logger $logger,  $event_dispacher)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->event_dispacher =   $event_dispacher;
    }

    /**
     * Procesar SalidaBodega
     *
     * @param integer $id
     * @return bool
     * @throws NotValidStateException
     */
    public function procesar($id)
    {
        try {

            $salidaBodega = $this->em->getRepository('BusetaBodegaBundle:SalidaBodega')->find($id);

            if (!$salidaBodega) {
                //throw $this->createNotFoundException('Unable to find SalidaBodega entity.');
            }

            if ($salidaBodega->getEstadoDocumento() !== 'BO') {
                $this->logger->error(sprintf('El estado %s de la Salida de Bodega con id %d no se corresponde con el estado previo a procesado(BO).',
                    $salidaBodega->getEstadoDocumento(),
                    $salidaBodega->getId()
                ));
                throw new NotValidStateException();
            }
            // Cambiar estado de borrador(BO) a Procesado(PR)
            $salidaBodega->setEstadoDocumento('PR');

            $this->em->persist($salidaBodega);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar la Salida de Bodega: %s', $e->getMessage()));

            return false;
        }

    }


    /**
     * Completar SalidaBodega
     *
     * @param integer $id
     * @return bool
     */
    public function completar($id)
    {
        try {

            /** @var \Buseta\BodegaBundle\Entity\SalidaBodega $salidabodega */

            $salidabodega = $this->em->getRepository('BusetaBodegaBundle:SalidaBodega')->find($id);

            if (!$salidabodega) {
               // throw $this->createNotFoundException('Unable to find SalidaBodega entity.');
            }

            $salidabodegaLineas =  $this->em->getRepository('BusetaBodegaBundle:InventarioFisicoLinea')->findBy(array(
                'inventarioFisico' => $salidabodega,
            ));

            if($salidabodegaLineas != null)
            {
                $eventDispatcher = $this->event_dispacher; //  get('event_dispatcher');
                foreach ($salidabodegaLineas as $linea) {
                    /** @var \Buseta\BodegaBundle\Entity\InventarioFisicoLinea $linea */
                    $event = new FilterBitacoraEvent($linea);
                    $eventDispatcher->dispatch(BitacoraEvents::PRODUCTION_NEGATIVE, $event );//P+
                }
            }

            //Cambia el estado de Procesado a Completado
            $salidabodega->setEstadoDocumento('CO');
            $this->em->persist($salidabodega);
            $this->em->flush();

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar la salida de bodega: %s', $e->getMessage()));
            return false;
        }

    }

}
