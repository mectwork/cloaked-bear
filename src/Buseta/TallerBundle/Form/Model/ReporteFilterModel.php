<?php
namespace Buseta\TallerBundle\Form\Model;

class ReporteFilterModel
{
    /**
     * @var string
     */
    private $numero;

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