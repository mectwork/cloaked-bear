<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiltroHidraulico.
 *
 * @ORM\Table(name="d_vehiculo_filtro_hidraulico")
 * @ORM\Entity
 */
class FiltroHidraulico
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
     * @ORM\Column(name="filtroHidraulico1", type="string", length=15)
     */
    private $filtroHidraulico1;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroHidraulico2", type="string", length=15)
     */
    private $filtroHidraulico2;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="filtroHidraulico")
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
     * @param string $filtroHidraulico1
     */
    public function setFiltroHidraulico1($filtroHidraulico1)
    {
        $this->filtroHidraulico1 = $filtroHidraulico1;
    }

    /**
     * @return string
     */
    public function getFiltroHidraulico1()
    {
        return $this->filtroHidraulico1;
    }

    /**
     * @param string $filtroHidraulico2
     */
    public function setFiltroHidraulico2($filtroHidraulico2)
    {
        $this->filtroHidraulico2 = $filtroHidraulico2;
    }

    /**
     * @return string
     */
    public function getFiltroHidraulico2()
    {
        return $this->filtroHidraulico2;
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
        return $this->filtroHidraulico1 && $this->filtroHidraulico2;
    }
}
