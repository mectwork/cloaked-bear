<?php

namespace Buseta\CoreBundle\Managers;

use Doctrine\ORM\EntityManager;

class CambioHoraSistemaManager
{
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return bool|\DateTime
     */
    public function getHoraCambio()
    {
        $horaCambioConfig = $this->em->getRepository('CoreBundle:CambioHoraSistema')->findAll();

        if(count($horaCambioConfig) == 1)
        {
            $horaCambioConfig = $horaCambioConfig[0];
            if($horaCambioConfig->getActivo())
                $horaCambio = $horaCambioConfig->getHora();
        }

        if(!isset($horaCambio) || $horaCambio==null)
            $horaCambio = false;

        return $horaCambio;
    }




} 