<?php

namespace Buseta\BodegaBundle\Event;
use Buseta\BodegaBundle\Entity\InventarioFisico;
use Symfony\Component\EventDispatcher\Event;

class FilterInventarioFisicoEvent extends Event
{
    /**
     * @var \Buseta\BodegaBundle\Entity\InventarioFisico
     */
    private $inventariofisico;

    private $valorretorno;

    /**
     * @param \Buseta\BodegaBundle\Entity\InventarioFisico $inventariofisico
     */
    function __construct( InventarioFisico $inventariofisico )
    {
        $this->inventariofisico = $inventariofisico;
        $this->valorretorno = true;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\InventarioFisico $inventariofisico
     */
    public function getEntityData()
    {
        return $this->inventariofisico;
    }

    public function setReturnValue($valorretorno)
    {
        $this->valorretorno = $valorretorno;
    }


    public function getReturnValue()
    {
       return $this->valorretorno ;
    }

}
