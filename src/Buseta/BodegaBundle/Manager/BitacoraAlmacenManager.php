<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
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

    public function createRegistry(BitacoraAlmacen $bitacora)
    {
        try {
            //el validator valida por los assert de la entity
            $validationOrigen = $this->validator->validate($bitacora);
            if ($validationOrigen->count() === 0) {
                $this->em->persist($bitacora);
            } else {
                $errors = '';
                foreach ($validationOrigen->getIterator() as $param => $error) {
                    $errors .= sprintf('%s: %s. ', $param, $error);
                }
                $this->logger->error(sprintf('BitacoraAlmacen.Validation: %s', $errors));
                return 'Error en la validacion de la Bitacora';
            }

            //si todo bien y  no hay errores devuelvo true
            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));
            //hacer rollback en el futuro
            return 'Error guardando la Bitacora';
        }
    }
}
