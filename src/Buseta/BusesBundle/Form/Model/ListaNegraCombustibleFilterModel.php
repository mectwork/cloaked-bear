<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Buseta\BusesBundle\Entity\ListaNegraCombustible;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ListaNegraCombustibleFilterModel.
 */
class ListaNegraCombustibleFilterModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     */
    private $autobus;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param Autobus $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

}
