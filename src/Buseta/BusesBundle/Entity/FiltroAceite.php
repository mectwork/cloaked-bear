<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiltroAceite.
 *
 * @ORM\Table(name="d_vehiculo_filtro_aceite")
 * @ORM\Entity
 */
class FiltroAceite
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
     * @ORM\Column(name="filtroAceite1", type="string", length=15)
     */
    private $filtroAceite1;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroAceite2", type="string", length=15)
     */
    private $filtroAceite2;

    /**
     * @var string
     *
     * @ORM\Column(name="filtroAceite3", type="string", length=15)
     */
    private $filtroAceite3;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="filtroAceite")
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
     * @param string $filtroAceite1
     */
    public function setFiltroAceite1($filtroAceite1)
    {
        $this->filtroAceite1 = $filtroAceite1;
    }

    /**
     * @return string
     */
    public function getFiltroAceite1()
    {
        return $this->filtroAceite1;
    }

    /**
     * @param string $filtroAceite2
     */
    public function setFiltroAceite2($filtroAceite2)
    {
        $this->filtroAceite2 = $filtroAceite2;
    }

    /**
     * @return string
     */
    public function getFiltroAceite2()
    {
        return $this->filtroAceite2;
    }

    /**
     * @param string $filtroAceite3
     */
    public function setFiltroAceite3($filtroAceite3)
    {
        $this->filtroAceite3 = $filtroAceite3;
    }

    /**
     * @return string
     */
    public function getFiltroAceite3()
    {
        return $this->filtroAceite3;
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
        return $this->filtroAceite1 && $this->filtroAceite2 && $this->filtroAceite3;
    }
}
