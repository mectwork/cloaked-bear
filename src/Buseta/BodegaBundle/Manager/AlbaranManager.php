<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;

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
     * @param ObjectManager $em
     * @param Logger $logger
     */
    function __construct(ObjectManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }


    public function create()
    {

    }

    /**
     * Action take place to process Albaran
     *
     * @param Albaran $albaran
     * @return bool
     * @throws NotValidStateException
     */
    public function process(Albaran $albaran)
    {
            if ($albaran->getEstadoDocumento() !== 'DR') {
                $this->logger->error(sprintf('El estado %s del Albaran con id %d no se corresponde con el estado previo a procesado(PO).',
                    $albaran->getEstadoDocumento(),
                    $albaran->getId()
                ));
                throw new NotValidStateException();
            }

            // Change state Draft(DR) to Process(PO)
            $albaran->setEstadoDocumento('PO');

        try {
            $this->em->persist($albaran);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al procesar Albaran: %s', $e->getMessage()));

            return false;
        }
    }

    public function complete(Albaran $albaran)
    {

    }
}
