<?php

namespace Buseta\BodegaBundle\Event;

use Buseta\BodegaBundle\Model\BitacoraEventModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractBitacoraEvent
 *
 * @package Buseta\BodegaBundle\Event
 */
abstract class AbstractBitacoraEvent extends Event implements BitacoraEventInterface
{
    /**
     * @var ArrayCollection
     */
    protected $bitacoraEvents;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var boolean
     */
    protected $flush;


    /**
     * AbstractBitacoraEvent constructor.
     *
     * @param bool $flush
     */
    public function __construct($flush=false)
    {
        $this->flush = $flush;
        $this->bitacoraEvents = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function isFlush()
    {
        return $this->flush;
    }

    /**
     * {@inheritdoc}
     */
    public function getBitacoraEvents()
    {
        $this->bitacoraEvents;
    }

    /**
     * @param BitacoraEventModel $bitacoraEvent
     */
    public function addBitacoraEvent(BitacoraEventModel $bitacoraEvent)
    {
        $this->bitacoraEvents->add($bitacoraEvent);
    }

    /**
     * {@inheritdoc}
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set BitacoraEvent error
     *
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}
