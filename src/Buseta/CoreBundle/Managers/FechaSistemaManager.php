<?php

namespace Buseta\CoreBundle\Managers;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Util\StringUtils;

class FechaSistemaManager
{
    private $em;
    private $cambioHoraManager;

    function __construct(EntityManager $em, CambioHoraSistemaManager $cambioHoraManager)
    {
        $this->em                   = $em;
        $this->cambioHoraManager    = $cambioHoraManager;
    }

    /**
     * @return \DateTime
     */
    public function getFechaSistema()
    {
        //comprobando si existe fecha de sistema activa
        $fechaSistemaConfig = $this->em->getRepository('CoreBundle:FechaSistema')->findAll();
        if(count($fechaSistemaConfig) == 1)
        {
            $fechaSistemaConfig = $fechaSistemaConfig[0];
            if($fechaSistemaConfig->getActivo())
                $fechaSistema = $fechaSistemaConfig->getFecha();
        }

        if(!isset($fechaSistema) || $fechaSistema == null)
        {
            $horaCambio = $this->cambioHoraManager->getHoraCambio();
            $fechaSistema = new \DateTime();

            if($horaCambio)
            {
                $horaCambio_normalized = $horaCambio->getTimestamp();
                $fechaSistema_normalized = $fechaSistema->getTimestamp();
                if($horaCambio_normalized > $fechaSistema_normalized)
                {
                    $fechaSistema = new \DateTime(date('Y-m-d H:i:s',strtotime($fechaSistema->format('Y-m-d H:i:s').' - 1 days')));
                }
            }
        }

        return $fechaSistema;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        //comprobando si existe fecha de sistema activa
        $fechaSistemaConfig = $this->em->getRepository('CoreBundle:FechaSistema')->findAll();
        if(count($fechaSistemaConfig) == 1)
        {
            $fechaSistemaConfig = $fechaSistemaConfig[0];
            if($fechaSistemaConfig->getActivo())
                return true;
        }
        return false;
    }

    /**
     * @param \DateTime $date
     * @return bool
     */
    public function isTodayDate(\DateTime $date)
    {
        $fechaSistema = $this->getFechaSistema();

        $dateString         = date_format($date, 'Y-m-d');
        $fechaSistemaString = date_format($fechaSistema, 'Y-m-d');

        return StringUtils::equals($dateString, $fechaSistemaString);
    }
} 