<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Buseta\BodegaBundle\Event\BitacoraEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;
use Doctrine\DBAL\Connections;


/**
 * Class AlbaranManager
 * @package Buseta\BodegaBundle\Manager
 */
class MovimientoManager
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
     * @param ObjectManager            $em
     * @param Logger                   $logger
     * @param EventDispatcherInterface $event_dispacher
     */
    function __construct(
        ObjectManager $em,
        Logger $logger,
        EventDispatcherInterface $event_dispacher
    ) {
        $this->em = $em;
        $this->logger = $logger;
        $this->event_dispacher = $event_dispacher;
    }

    /**
     * Procesar Movimiento
     *
     * @param integer $id
     * @return bool
     * @throws NotValidStateException
     */
    public function procesar($id)
    {
        try {

            $movimiento = $this->em->getRepository('BusetaBodegaBundle:Movimiento')->find($id);

            if (!$movimiento) {
                throw new NotFoundElementException('Unable to find Movimiento entity.');
            }

            if ($movimiento->getEstadoDocumento() !== 'BO') {
                $this->logger->error(sprintf('El estado %s del Movimiento con id %d no se corresponde con el estado previo a procesado(BO).',
                    $movimiento->getEstadoDocumento(),
                    $movimiento->getId()
                ));
                throw new NotValidStateException();
            }

            // Cambiar estado de borrador(BO) a Procesado(PR)
            $movimiento->setEstadoDocumento('PR');
            $this->em->persist($movimiento);

            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Movimiento: %s', $e->getMessage()));
            return 'Ha ocurrido un error al procesar el Movimiento';
        }

    }

    /**
     * Completar Movimiento
     *
     * @param integer $id
     * @return bool
     */
    public function completar($id)
    {
        /** @var \Buseta\BodegaBundle\Entity\Movimiento $movimiento */
        /** @var \Buseta\BodegaBundle\Entity\MovimientosProductos $linea */

        // suspend auto-commit
        $this->em->getConnection()->beginTransaction();

        try {

            $movimiento = $this->em->getRepository('BusetaBodegaBundle:Movimiento')->find($id);
            if (!$movimiento) {
                throw new NotFoundElementException('Unable to find Movimiento entity.');
            }

            $movimientos = $movimiento->getMovimientosProductos();

            if ($movimientos !== null && count($movimientos) > 0) {
                //entonces mando a crear los movimientos en la bitacora, producto a producto, a traves de eventos
                foreach ($movimientos as $linea) {
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
                }

                //Cambia el estado de Procesado a Completado e incorpora otros datos
                $username = $this->security_context->getToken()->getUser()->getUsername();
                //$movimiento->setCreatedBy($username);
                $movimiento->setMovidoBy($username);
                $movimiento->setFechaMovimiento($fechaSalidaBodega = new \DateTime());
                $movimiento->setEstadoDocumento('CO');
                $this->em->persist($movimiento);

            } else {
                // Rollback the failed transaction attempt
                $this->em->getConnection()->rollback();
                return $error = 'El movimiento debe tener al menos un producto';
            }

            //finalmentele damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales
            //es el unico flush que se hace.
            $this->em->flush();

            // Try and commit the transaction, aqui puede ocurrir un error
            $this->em->getConnection()->commit();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al completar el movimiento: %s',
                $e->getMessage()));
            //borramos los cambios en el entity manager
            //$this->em->clear();

            // Rollback the failed transaction attempt
            $this->em->getConnection()->rollback();

            return $error = 'Ha ocurrido un error al completar el movimiento';
        }
    }
}
