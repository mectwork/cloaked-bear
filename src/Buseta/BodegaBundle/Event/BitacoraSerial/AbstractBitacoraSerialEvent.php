<?php

namespace Buseta\BodegaBundle\Event\BitacoraSerial;


use Buseta\BodegaBundle\Extras\GeneradorSeriales;
use Buseta\BodegaBundle\Model\BitacoraSerialEventModel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AbstractBitacoraSerialEvent
 *
 * @package Buseta\BodegaBundle\Event\BitacoraSerial
 */
class AbstractBitacoraSerialEvent extends Event implements BitacoraSerialEventInterface
{
    /**
     * @var ArrayCollection
     */
    protected $bitacoraSerialEvents;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var boolean
     */
    protected $flush;

    /**
     * @var GeneradorSeriales
     */
    protected $generadorSeriales;


    /**
     * AbstractBitacoraEvent constructor.
     *
     * @param bool $flush
     */
    public function __construct($flush=false)
    {
        $this->flush = $flush;
        $this->bitacoraSerialEvents = new ArrayCollection();
        $this->generadorSeriales = new GeneradorSeriales();
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
    public function getBitacoraSerialEvents()
    {
        return $this->bitacoraSerialEvents;
    }

    /**
     * @param BitacoraSerialEventModel $bitacoraSerialEvent
     */
    public function addBitacoraEvent(BitacoraSerialEventModel $bitacoraSerialEvent)
    {
        $this->bitacoraSerialEvents->add($bitacoraSerialEvent);
    }

    /**
     * {@inheritdoc}
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * {@inheritdoc}
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}
