<?php

namespace Buseta\BodegaBundle\Event;
use Buseta\BodegaBundle\Interfaces\GeneradorBitacoraInterface;
use Symfony\Component\EventDispatcher\Event;

class FilterBitacoraEvent extends Event
{
    /**
     * @var \Buseta\BodegaBundle\Interfaces\GeneradorBitacoraInterface
     */
    private $generadorbitacora;

    private $valorretorno;

    /**
     * @param \Buseta\BodegaBundle\Interfaces\GeneradorBitacoraInterface $generadorbitacora
     */
    function __construct( GeneradorBitacoraInterface $generadorbitacora )
    {
        $this->generadorbitacora = $generadorbitacora;
        $this->valorretorno = true;
    }

    /**
     * @return \Buseta\BodegaBundle\Interfaces\GeneradorBitacoraInterface $generadorbitacora
     */
    public function getEntityData()
    {
        return $this->generadorbitacora;
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
