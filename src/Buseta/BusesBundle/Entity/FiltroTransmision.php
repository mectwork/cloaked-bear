<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiltroTransmision.
 *
 * @ORM\Table(name="d_filtro_transmision")
 * @ORM\Entity
 */
class FiltroTransmision
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroTransmision", type="string", length=15)
     */
    private $filtroTransmision;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="filtroTransmision")
     */
    private $autobus;

    /**
     * @param mixed $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * @return mixed
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param string $filtroTransmision
     */
    public function setFiltroTransmision($filtroTransmision)
    {
        $this->filtroTransmision = $filtroTransmision;
    }

    /**
     * @return string
     */
    public function getFiltroTransmision()
    {
        return $this->filtroTransmision;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Comprueba si contiene datos el filtro.
     *
     * @return bool
     */
    public function hasData()
    {
        return $this->filtroTransmision;
    }
}
