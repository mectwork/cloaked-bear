<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiltroDiesel.
 *
 * @ORM\Table(name="d_filtro_diesel")
 * @ORM\Entity
 */
class FiltroDiesel
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
     * @ORM\Column(name="filtroDiesel1", type="string", length=15)
     */
    private $filtroDiesel1;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroDiesel2", type="string", length=15)
     */
    private $filtroDiesel2;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroDiesel3", type="string", length=15)
     */
    private $filtroDiesel3;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroDiesel4", type="string", length=15)
     */
    private $filtroDiesel4;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="filtroDiesel")
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
     * @param string $filtroDiesel1
     */
    public function setFiltroDiesel1($filtroDiesel1)
    {
        $this->filtroDiesel1 = $filtroDiesel1;
    }

    /**
     * @return string
     */
    public function getFiltroDiesel1()
    {
        return $this->filtroDiesel1;
    }

    /**
     * @param string $filtroDiesel2
     */
    public function setFiltroDiesel2($filtroDiesel2)
    {
        $this->filtroDiesel2 = $filtroDiesel2;
    }

    /**
     * @return string
     */
    public function getFiltroDiesel2()
    {
        return $this->filtroDiesel2;
    }

    /**
     * @param string $filtroDiesel3
     */
    public function setFiltroDiesel3($filtroDiesel3)
    {
        $this->filtroDiesel3 = $filtroDiesel3;
    }

    /**
     * @return string
     */
    public function getFiltroDiesel3()
    {
        return $this->filtroDiesel3;
    }

    /**
     * @param string $filtroDiesel4
     */
    public function setFiltroDiesel4($filtroDiesel4)
    {
        $this->filtroDiesel4 = $filtroDiesel4;
    }

    /**
     * @return string
     */
    public function getFiltroDiesel4()
    {
        return $this->filtroDiesel4;
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
        return $this->filtroDiesel1 && $this->filtroDiesel2 && $this->filtroDiesel3 && $this->filtroDiesel4;
    }
}
