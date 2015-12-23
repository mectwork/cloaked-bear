<?php

namespace Buseta\TallerBundle\Manager;

use Buseta\TallerBundle\Entity\Diagnostico;
use Buseta\TallerBundle\Entity\Reporte;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;

class ReporteManager
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
        $this->em               = $em;
        $this->logger           = $logger;
    }


    /**
     * Crea un diagnostico a partir de un reporte
     * @param Reporte $reporte
     * @return Boolean resultado
     */
    public function crearDiagnostico(Reporte $reporte)
    {
        try {
            //Crear nuevo Diagnostico a partir del Reporte seleccionado
            $diagnostico = new Diagnostico();
            $diagnostico->setNumero( $reporte->getNumero() );
            $diagnostico->setReporte($reporte);
            $diagnostico->setAutobus($reporte->getAutobus());

            $this->em->persist($diagnostico);
            $this->em->flush();

            return true;

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Diagnostico.Persist: %s', $e->getMessage()));
            return false;
         }
    }

    /**
     * Cambia es estado de un reporte
     * @param Reporte $reporte
     * @param string $estado
     */
    public function cambiarEstado( Reporte $reporte , $estado = 'BO' )
    {
        //Cambia el estado
        $reporte->setEstado( $estado);
        $this->em->persist($reporte);
        $this->em->flush();
    }

}
