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
    function __construct(Albaran $albaran, $flush=true)
    {
        $this->albaran = $albaran;
        $this->error = false;
        $this->flush = $flush;
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
