<?php

namespace Buseta\TallerBundle\Manager;

use Buseta\TallerBundle\Entity\Diagnostico;
use Buseta\TallerBundle\Entity\OrdenTrabajo;
use Buseta\TallerBundle\Entity\TareaAdicional;
use Buseta\TallerBundle\Entity\TareaDiagnostico;
use Doctrine\Common\Persistence\ObjectManager;
use HatueySoft\SequenceBundle\Managers\SequenceManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\Security\Core\Util\ClassUtils;

class OrdenTrabajoManager
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
     * @var \HatueySoft\SequenceBundle\Managers\SequenceManager
     */
    private $sequenceManager;

    /**
     * @param ObjectManager $em
     * @param Logger $logger
     */
    function __construct(ObjectManager $em, Logger $logger, SequenceManager $sequenceManager)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->sequenceManager = $sequenceManager;
    }


    public function cambiarEstado(OrdenTrabajo $orden, $estado = 'BO')
    {
        try {
            $orden->setEstado($estado);
            //ver si necesito el persist ya que el elemento ya esta en la base de datos
            $this->em->persist($orden);
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('OrdenTrabajo.Persist: %s', $e->getMessage()));

            return false;
        }
    }

    public function cambiarCancelado(OrdenTrabajo $orden)
    {
        try {
            $cancelado = $orden->getCancelado();
            if ($cancelado == false) {
                $orden->setCancelado(true);
                $this->em->persist($orden);
                $this->em->flush();
            }

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('OrdenTrabajo.Persist: %s', $e->getMessage()));

            return false;
        }
    }

    /**
     * Crea una orden de trabajo a partir de un diagnostico
     * @param Diagnostico $diagnostico
     * @return Boolean $resultado
     */
    public function crearOrdenTrabajo(Diagnostico $diagnostico)
    {
        try {
            //Crear nueva orden de trabajo a partir del Diagnostico seleccionado
            $ordenTrabajo = new OrdenTrabajo();


            if (($this->sequenceManager->getNextValue('ot_seq')) != null) {
                if ($this->sequenceManager->hasSequence(ClassUtils::getRealClass($ordenTrabajo))) {
                    $ordenTrabajo->setNumero($this->sequenceManager->getNextValue('ot_seq'));

                } else {
                    $ordenTrabajo->setNumero( $diagnostico->getNumero() );

                }
            }
            $ordenTrabajo->setDiagnostico($diagnostico);
            $ordenTrabajo->setAutobus($diagnostico->getAutobus());
            $ordenTrabajo->setCancelado(false);
            $ordenTrabajo->setEstado('BO');
            $ordenTrabajo->setDiagnostico($diagnostico);

            $this->em->persist($ordenTrabajo);

            $tareasDiag = $diagnostico->getTareaDiagnostico();
            /** @var TareaDiagnostico $taDiag */
            /** @var TareaAdicional $taAdic */
            foreach($tareasDiag as $taDiag){
                $taAdic = new TareaAdicional();
                $taAdic->setOrdenTrabajo($ordenTrabajo);
                $taAdic->setGrupo($taDiag->getGrupo());
                $taAdic->setSubgrupo($taDiag->getSubgrupo());
                $taAdic->setTareaMantenimiento($taDiag->getTareaMantenimiento());
                $taAdic->setDescripcion($taDiag->getDescripcion());
                $this->em->persist($taAdic);
            }

            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Diagnostico.Persist: %s', $e->getMessage()));

            return false;
        }
    }
}
