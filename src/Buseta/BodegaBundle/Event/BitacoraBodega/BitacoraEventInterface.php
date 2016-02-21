<?php

namespace Buseta\BodegaBundle\Event\BitacoraBodega;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface BitacoraEventInterface
 *
 * @package Buseta\BodegaBundle\Event\BitacoraBodega
 */
interface BitacoraEventInterface
{
    /**
     * Check if the subscriber must flush the data
     *
     * @return boolean
     */
    public function isFlush();

    /**
     * Gets the entire collections for the events to register in trace.
     *
     * @return ArrayCollection
     */
    public function getBitacoraEvents();

    /**
     * Gets error during event call if any.
     *
     * @return string
     */
    public function getError();

    /**
     * Set Bitacora event error.
     *
     * @param string $error
     */
    public function setError($error);
}
