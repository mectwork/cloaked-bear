<?php

namespace Buseta\BodegaBundle\Manager;


use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator;
use Symfony\Bridge\Monolog\Logger;

class BitacoraAlmacenManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Component\Validator\Validator
     */
    private $validator;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;


    /**
     * @param ObjectManager $em
     * @param Logger $logger
     * @param Validator $validator
     */
    function __construct(ObjectManager $em, Logger $logger, Validator $validator)
    {
        $this->em               = $em;
        $this->validator        = $validator;
        $this->logger           = $logger;
    }

    public function createRegistry(BitacoraAlmacen $bitacoraAlmacen)
    {
        $validation = $this->validator->validate($bitacoraAlmacen);
        if ($validation->count() === 0) {
            try {
                $this->em->persist($bitacoraAlmacen);
                $this->em->flush();

                return true;
            } catch (\Exception $e) {
                $this->logger->error(sprintf('BitacoraAlmacen.Persist: %s', $e->getMessage()));

                return false;
            }
        } else {
            $errors = '';
            foreach ($validation->getIterator() as $param => $error) {
                $errors .= sprintf('%s: %s. ', $param, $error);
            }
            $this->logger->error(sprintf('BitacoraAlmacen.Validation: %s', $errors));

            return false;
        }
    }
}
