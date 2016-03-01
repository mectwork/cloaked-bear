<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\Entity\SalidaBodega;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FilterSalidaBodegaEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class FilterSalidaBodegaEvent extends Event
{
    /**
     * @var SalidaBodega
     */
    private $salidaBodega;

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
     * @param SalidaBodega $salidaBodega
     * @param boolean $flush
     */
    function __construct(SalidaBodega $salidaBodega, $flush=true)
    {
        $this->salidaBodega = $salidaBodega;
        $this->error = false;
        $this->flush = $flush;
    }

    /**
     * @return SalidaBodega
     */
    public function getSalidaBodega()
    {
        return $this->salidaBodega;
    }

    /**
     * @param SalidaBodega $salidaBodega
     */
    public function setSalidaBodega($salidaBodega)
    {
        $this->salidaBodega = $salidaBodega;
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
