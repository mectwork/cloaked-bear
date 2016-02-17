<?php

namespace Buseta\BodegaBundle\Event;


use Doctrine\Common\Collections\ArrayCollection;

interface BitacoraEventInterface
{
    /**
     * Gets the entire collections for the events to register in trace.
     *
     * @return ArrayCollection
     */
    public function getBitacoraEvents();
}
