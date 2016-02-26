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
use Doctrine\DBAL\Connections;

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

        $errors = array();

        try {

            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                $errors[] = 'No se encontro la entidad Albaran.';
                throw new \Exception();
            }

            //validaciones para poder hacer el cambio de estado.
            if ($albaran->getEstadoDocumento() !== 'BO') {
                $error = sprintf('El estado %s de la Orden de Entrada con id %d no se corresponde con el estado previo a procesado(PR).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                );
                $errors[] = $error;
            }

            if (($albaran->getFechaMovimiento() == null) || $albaran->getFechaMovimiento() == '') {
                $error = sprintf('La fecha de movimiento de la Orden de Entrada con id %d no es valida, edite la Orden de Entrada e introduzca una fecha valida.',
                    $albaran->getId()
                );
                $errors[] = $error;
            }

            if (count($errors) > 0) {
                throw new \Exception();
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

            $errorsDetalles = '';
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->logger->error(sprintf('Ha ocurrido un error al procesar la Orden de Entrada. Detalles: %s',
                        $error));
                    $errorsDetalles .= $error . ' ';
                }
            } else {
                $errorsDetalles = 'Existen datos no validos';
                $this->logger->error(sprintf('Ha ocurrido un error al procesar la Orden de Entrada. Detalles: %s',
                    $e->getMessage()));
            }

            //borramos los cambios en el entity manager
            $this->em->clear();
            return sprintf('Detalles: %s', $errorsDetalles);

        }

    }

    /**
     * @param $id
     * @return bool|string
     */
    public function revertir($id)
    {
        try {

            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                throw new NotFoundElementException('No se encontro la entidad Albaran.');
            }

            if ($albaran->getEstadoDocumento() !== 'PR') {
                $this->logger->error(sprintf('El estado %s del Albaran con id %d no se corresponde con el estado previo a procesado(PR).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                ));
                throw new NotValidStateException();
            }

            // Change state Borrador(PR) to Procesado(BO)
            $albaran->setEstadoDocumento('BO');

            $this->em->flush();
            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar el Albaran: %s', $e->getMessage()));
            //borramos los cambios en el entity manager
            $this->em->clear();
            return 'Ha ocurrido un error al procesar el Albaran';
        }

    }

    /**
     * Completar Albaran
     *
     * @param integer $id
     * @return bool
     */
    public function completar($id)
    {
        /** @var \Buseta\BodegaBundle\Entity\Albaran $albaran */
        /** @var \Buseta\BodegaBundle\Entity\AlbaranLinea $lineas */

        // suspend auto-commit
        $this->em->getConnection()->beginTransaction();

        try {

            $albaran = $this->em->getRepository('BusetaBodegaBundle:Albaran')->find($id);

            if (!$albaran) {
                throw new NotFoundElementException('No se encontro la entidad Albaran.');
            }

            $albaranLineas = $albaran->getAlbaranLineas();

            if ($albaranLineas !== null && count($albaranLineas) > 0) {
                //entonces mando a crear los movimientos en la bitacora, producto a producto, a traves de eventos
                foreach ($albaranLineas as $linea) {
                    $event = new FilterBitacoraEvent($linea);
                    $this->dispatcher->dispatch(BitacoraEvents::VENDOR_RECEIPTS, $event);
                    $result = $event->getReturnValue();
                    if ($result !== true) {
                        // Rollback the failed transaction attempt
                        $this->em->getConnection()->rollback();
                        return $error = $result;
                    }
                }

                // Change state to 'CO'
                $event = new FilterAlbaranEvent($albaran);
                $this->dispatcher->dispatch(AlbaranEvents::POS_COMPLETE, $event);
                $result = $event->getReturnValue();
                if ($result !== true) {
                    // Rollback the failed transaction attempt
                    $this->em->getConnection()->rollback();
                    return $error = $result;
                }
            } else {
                // Rollback the failed transaction attempt
                $this->em->getConnection()->rollback();
                return $error = 'La Orden de Entrega debe tener al menos una linea';
            }

            //finalmente le damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales yel cambio de estado
            //es el unico flush que se hace.
            $this->em->flush();

            // Try and commit the transaction, aqui puede ocurrir un error
            $this->em->getConnection()->commit();

            return true;

        } catch (\Exception $e) {

            $this->logger->error(sprintf('Ha ocurrido un error al procesar la Orden de Entrega: %s',
                $e->getMessage()));

            // Rollback the failed transaction attempt
            $this->em->getConnection()->rollback();

            //$this->em->clear();
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
