<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiltroCaja.
 *
 * @ORM\Table(name="d_vehiculo_filtro_caja")
 * @ORM\Entity
 */
class FiltroCaja
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
     * @ORM\Column(name="filtroCaja1", type="string", length=15)
     */
    private $filtroCaja1;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroCaja2", type="string", length=15)
     */
    private $filtroCaja2;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="filtroCaja")
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
     * @param string $filtroCaja1
     */
    public function setFiltroCaja1($filtroCaja1)
    {
        $this->filtroCaja1 = $filtroCaja1;
    }

    /**
     * @return string
     */
    public function getFiltroCaja1()
    {
        return $this->filtroCaja1;
    }

    /**
     * @param string $filtroCaja2
     */
    public function setFiltroCaja2($filtroCaja2)
    {
        $this->filtroCaja2 = $filtroCaja2;
    }

    /**
     * @return string
     */
    public function getFiltroCaja2()
    {
        return $this->filtroCaja2;
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
        return $this->filtroCaja1 && $this->filtroCaja2;
    }
}
