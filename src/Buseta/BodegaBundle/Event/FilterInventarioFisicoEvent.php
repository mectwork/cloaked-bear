<?php

namespace Buseta\BodegaBundle\Event;
use Buseta\BodegaBundle\Entity\InventarioFisico;
use Symfony\Component\EventDispatcher\Event;

class FilterInventarioFisicoEvent extends Event
{
    /**
     * @var \Buseta\BodegaBundle\Entity\InventarioFisico
     */
    private $inventarioFisico;

    /**
     * @var boolean|string
     */
    private $error;

    /**
     * @var boolean
     */
    private $flush;


    /**
     * @param InventarioFisico $inventarioFisico
     * @param boolean $flush
     */
    function __construct(InventarioFisico $inventarioFisico, $flush=true)
    {
        $this->inventarioFisico = $inventarioFisico;
        $this->error = false;
        $this->flush = $flush;
    }

    /**
     * @return InventarioFisico
     */
    public function getInventarioFisico()
    {
        return $this->inventarioFisico;
    }

    /**
     * @param InventarioFisico $inventarioFisico
     */
    public function setInventarioFisico($inventarioFisico)
    {
        $this->inventarioFisico = $inventarioFisico;
    }

    /**
     * @return bool|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param bool|string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return boolean
     */
    public function isFlush()
    {
        return $this->flush;
    }
}
