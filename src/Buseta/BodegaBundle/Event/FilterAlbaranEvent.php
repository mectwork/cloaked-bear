<?php

namespace Buseta\BodegaBundle\Event;
use Buseta\BodegaBundle\Entity\Albaran;
use Symfony\Component\EventDispatcher\Event;

class FilterAlbaranEvent extends Event
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Albaran
     */
    private $albaran;

    private $valorretorno;

    /**
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     */
    function __construct( Albaran $albaran )
    {
        $this->albaran = $albaran;
        $this->valorretorno = true;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Albaran $albaran
     */
    public function getEntityData()
    {
        return $this->albaran;
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
