<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;


use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface BitacoraSerialEventInterface
 *
 * @package Buseta\BodegaBundle\Event\BitacoraSerial
 */
interface BitacoraSerialEventInterface
{
    /**
     * Check if the subscriber must flush the data
     *
     * @return boolean
     */
    public function isFlush();

    /**
     * Gets the entire collections for the serial events to register in trace.
     *
     * @return ArrayCollection
     */
    public function getBitacoraSerialEvents();

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
