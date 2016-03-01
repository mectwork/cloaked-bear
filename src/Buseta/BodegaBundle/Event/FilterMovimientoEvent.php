<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\Entity\Movimiento;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class FilterMovimientoEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
class FilterMovimientoEvent extends Event
{
    /**
     * @var Movimiento
     */
    private $movimiento;

    /**
     * @var boolean|string
     */
    private $error;

    /**
     * @var boolean
     */
    private $flush;


    /**
     * @param Movimiento $movimiento
     * @param boolean $flush
     */
    function __construct(Movimiento $movimiento, $flush=true)
    {
        $this->movimiento = $movimiento;
        $this->error = false;
        $this->flush = $flush;
    }

    /**
     * @return Movimiento
     */
    public function getMovimiento()
    {
        return $this->movimiento;
    }

    /**
     * @param Movimiento $movimiento
     */
    public function setMovimiento($movimiento)
    {
        $this->movimiento = $movimiento;
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
