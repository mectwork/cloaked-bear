<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\Entity\Albaran;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FilterAlbaranEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class FilterAlbaranEvent extends Event
{
    /**
     * @var Albaran
     */
    private $albaran;

    /**
     * @var boolean
     */
    private $valorretorno;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @var boolean
     */
    private $flush;

    /**
     * FilterAlbaranEvent constructor
     *
     * @param Albaran $albaran
     * @param boolean $flush
     */
    function __construct(Albaran $albaran, $flush=false)
    {
        $this->albaran = $albaran;
        $this->valorretorno = true;
        $this->flush = $flush;
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

    /**
     * @return Albaran
     */
    public function getAlbaran()
    {
        return $this->albaran;
    }

    /**
     * @param Albaran $albaran
     */
    public function setAlbaran($albaran)
    {
        $this->albaran = $albaran;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
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
