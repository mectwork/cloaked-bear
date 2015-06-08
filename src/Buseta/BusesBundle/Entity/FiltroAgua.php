<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiltroAgua.
 *
 * @ORM\Table(name="d_filtro_agua")
 * @ORM\Entity
 */
class FiltroAgua
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
     * @ORM\Column(name="filtroAgua1", type="string", length=15)
     */
    private $filtroAgua1;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroAgua2", type="string", length=15)
     */
    private $filtroAgua2;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="filtroAgua")
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
     * @param string $filtroAgua1
     */
    public function setFiltroAgua1($filtroAgua1)
    {
        $this->filtroAgua1 = $filtroAgua1;
    }

    /**
     * @return string
     */
    public function getFiltroAgua1()
    {
        return $this->filtroAgua1;
    }

    /**
     * @param string $filtroAgua2
     */
    public function setFiltroAgua2($filtroAgua2)
    {
        $this->filtroAgua2 = $filtroAgua2;
    }

    /**
     * @return string
     */
    public function getFiltroAgua2()
    {
        return $this->filtroAgua2;
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
        return $this->filtroAgua1 && $this->filtroAgua2;
    }
}
