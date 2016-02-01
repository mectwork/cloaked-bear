<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;
use Doctrine\DBAL\Connections;

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

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $event_dispacher;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    private $security_context;


    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param EventDispatcherInterface $event_dispacher
     * @param SecurityContext $security_context
     */
    function __construct(
        ObjectManager $em,
        Logger $logger,
        EventDispatcherInterface $event_dispacher,
        SecurityContext $security_context
    ) {
        $this->em = $em;
        $this->logger = $logger;
        $this->event_dispacher = $event_dispacher;
        $this->security_context = $security_context;
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
                throw new NotFoundElementException('Unable to find SalidaBodega entity.');
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
            return 'Ha ocurrido un error al procesar  la Salida de Bodega';
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
        /** @var \Buseta\BodegaBundle\Entity\SalidaBodega $salidaBodega */
        /** @var \Buseta\BodegaBundle\Entity\SalidaBodegaProducto $linea */

        // suspend auto-commit
        $this->em->getConnection()->beginTransaction();

        try {

            $salidaBodega = $this->em->getRepository('BusetaBodegaBundle:SalidaBodega')->find($id);

            if (!$salidaBodega) {
                throw new NotFoundElementException('Unable to find SalidaBodega entity.');
            }

            $salidasBodega = $salidaBodega->getSalidasProductos();

            if ($salidasBodega !== null && count($salidasBodega) > 0) {
                //entonces mando a crear los movimientos en la bitacora, producto a producto, a traves de eventos
                foreach ($salidasBodega as $linea) {
                    $event = new FilterBitacoraEvent($linea);
                    $this->event_dispacher->dispatch(BitacoraEvents::MOVEMENT_FROM /*M-*/, $event);
                    $result = $event->getReturnValue();
                    if ($result !== true) {
                        // Rollback the failed transaction attempt
                        $this->em->getConnection()->rollback();
                        return $error = $result;
                    }

                    $event = new FilterBitacoraEvent($linea);
                    $this->event_dispacher->dispatch(BitacoraEvents::MOVEMENT_TO /*M+*/, $event);
                    $result = $event->getReturnValue();
                    if ($result !== true) {
                        // Rollback the failed transaction attempt
                        $this->em->getConnection()->rollback();
                        return $error = $result;
                    }

                    //aunque debe ser de la siguiente forma
                    //$event = new FilterBitacoraEvent($linea);
                    //$eventDispatcher->dispatch(BitacoraEvents::PRODUCTION_NEGATIVE, $event);//P+
                }

                //Cambia el estado de Procesado a Completado e incorpora otros datos
                $username = $this->security_context->getToken()->getUser()->getUsername();
                //$salidaBodega->setCreatedBy($username);
                $salidaBodega->setMovidoBy($username);
                $salidaBodega->setFecha($fechaSalidaBodega = new \DateTime());
                $salidaBodega->setEstadoDocumento('CO');
                $this->em->persist($salidaBodega);

            } else {
                // Rollback the failed transaction attempt
                $this->em->getConnection()->rollback();
                return $error = 'La salida de bodega debe tener al menos un producto';
            }

            //finalmentele damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales
            //es el unico flush que se hace.
            $this->em->flush();

            // Try and commit the transaction, aqui puede ocurrir un error
            $this->em->getConnection()->commit();

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al completar la salida de bodega: %s',
                $e->getMessage()));

            // Rollback the failed transaction attempt
            $this->em->getConnection()->rollback();

            return $error = 'Ha ocurrido un error al completar la salida de bodega';
        }

    }

}
