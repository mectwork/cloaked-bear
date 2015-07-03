<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Buseta\BusesBundle\Entity\DespachadoraCombustible;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DespachadoraCombustibleFilterModel.
 */
class DespachadoraCombustibleFilterModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Buseta\BusesBundle\Entity\ConfiguracionCombustible
     */
    private $combustible;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     */
    private $autobus;

    /**
     * @var \Buseta\BusesBundle\Entity\Chofer
     */
    private $chofer;

    /**
     * Constructor
     */
    public function __construct(DespachadoraCombustible $despachadoraCombustible = null)
    {
        if ($despachadoraCombustible !== null) {
            $this->id = $despachadoraCombustible->getId();

            if ($despachadoraCombustible->getAutobus()) {
                $this->estadoCivil  = $despachadoraCombustible->getAutobus();
            }
            if ($despachadoraCombustible->getChofer()) {
                $this->nacionalidad  = $despachadoraCombustible->getChofer();
            }
            if ($despachadoraCombustible->getCombustible()) {
                $this->nacionalidad  = $despachadoraCombustible->getCombustible();
            }
        }
    }

    /**
     * @return DespachadoraCombustible
     */
    public function getEntityData()
    {
        $despachadoraCombustible = new DespachadoraCombustible();

        if ($this->getAutobus() !== null) {
            $despachadoraCombustible->setAutobus($this->getAutobus());
        }
        if ($this->getChofer() !== null) {
            $despachadoraCombustible->setChofer($this->getChofer());
        }
        if ($this->getCombustible() !== null) {
            $despachadoraCombustible->setCombustible($this->getCombustible());
        }

        return $despachadoraCombustible;
    }

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
     * @return \Buseta\BusesBundle\Entity\ConfiguracionCombustible
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\ConfiguracionCombustible $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
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
     * @return \Buseta\BusesBundle\Entity\Chofer
     */
    public function getChofer()
    {
        return $this->chofer;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\Chofer $chofer
     */
    public function setChofer($chofer)
    {
        $this->chofer = $chofer;
    }



}
