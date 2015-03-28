<?php
namespace Buseta\TallerBundle\Form\Model;

class DiagnosticoFilterModel
{
    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var \Buseta\TallerBundle\Entity\Reporte
     */
    private $reporte;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     */
    private $autobus;

    /**
     * @return \Buseta\BusesBundle\Entity\Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * @return \Buseta\TallerBundle\Entity\Reporte
     */
    public function getReporte()
    {
        return $this->reporte;
    }

    /**
     * @param \Buseta\TallerBundle\Entity\Reporte $reporte
     */
    public function setReporte($reporte)
    {
        $this->reporte = $reporte;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
} 