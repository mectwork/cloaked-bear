<?php
namespace Buseta\TallerBundle\Form\Model;

class CondicionesPagoFilterModel
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $meses_plazo;

    /**
     * @var integer
     */
    private $dias_plazo;

    /**
     * @return int
     */
    public function getDiasPlazo()
    {
        return $this->dias_plazo;
    }

    /**
     * @param int $dias_plazo
     */
    public function setDiasPlazo($dias_plazo)
    {
        $this->dias_plazo = $dias_plazo;
    }

    /**
     * @return int
     */
    public function getMesesPlazo()
    {
        return $this->meses_plazo;
    }

    /**
     * @param int $meses_plazo
     */
    public function setMesesPlazo($meses_plazo)
    {
        $this->meses_plazo = $meses_plazo;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}