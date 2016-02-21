<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BitacoraAlmacenManager
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param ValidatorInterface $validator
     */
    function __construct(ObjectManager $em, Logger $logger, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    public function createRegistry(BitacoraEventModel $model, $flush=false)
    {
        try {
            $registry = new BitacoraAlmacen();
            $registry->setAlmacen($model->getWarehouse());
            $registry->setProducto($model->getProduct());
            $registry->setFechaMovimiento($model->getMovementDate());
            $registry->setCantidadMovida($model->getMovementQty());
            $registry->setTipoMovimiento($model->getMovementType());
            if ($model->getQuantityOrder()) {
                $registry->setCantidadOrden($model->getQuantityOrder());
            }
            if ($model->getCallback() !== null) {
                call_user_func($model->getCallback(), $registry);
            }

            $this->em->persist($registry);
            if ($flush) {
                $this->em->flush();
            }

            return true;
        } catch(\Exception $e) {
            $this->logger->critical(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));

            return false;
        }
    }

    public function legacyCreateRegistry(BitacoraAlmacen $bitacora)
    {
        try {
            //el validator valida por los assert de la entity
            $validationOrigen = $this->validator->validate($bitacora);
            if ($validationOrigen->count() === 0) {
                $this->em->persist($bitacora);

                return true;
            } else {
                $errors = '';
                foreach ($validationOrigen->getIterator() as $param => $error) {
                    $errors .= sprintf('%s: %s. ', $param, $error);
                }
                $this->logger->error(sprintf('BitacoraAlmacen.Validation: %s', $errors));

                return false;
            }
        } catch (\Exception $e) {
            $this->logger->error(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));
            //hacer rollback en el futuro
            return false;
        }
    }
}
