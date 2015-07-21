<?php

namespace Buseta\BodegaBundle\Event;


use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Symfony\Component\EventDispatcher\Event;

class FilterBitacoraEvent extends Event
{
    /**
     * @var \Buseta\BodegaBundle\Entity\AlbaranLinea
     */
    private $albaranLinea;


    /**
     * @param $albaranLinea
     */
    function __construct(AlbaranLinea $albaranLinea)
    {
        $this->albaranLinea = $albaranLinea;
    }

    public function getEntityData()
    {
        $bitacora = new BitacoraAlmacen();
        $bitacora->setProducto($this->albaranLinea->getProducto());
        $bitacora->setAlmacen($this->albaranLinea->getAlmacen());
        $bitacora->setCantidadMovida($this->albaranLinea->getCantidadMovida());
        $bitacora->setFechaMovimiento($this->albaranLinea->getAlbaran()->getFechaMovimiento());

        return $bitacora;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\AlbaranLinea
     */
    public function getAlbaranLinea()
    {
        return $this->albaranLinea;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     *
     * @return $this
     */
    public function setAlbaranLinea($albaranLinea)
    {
        $this->albaranLinea = $albaranLinea;

        return $this;
    }
}
