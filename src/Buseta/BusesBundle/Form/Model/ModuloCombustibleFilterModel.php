<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Buseta\BusesBundle\Entity\ModuloCombustible;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ModuloCombustibleFilterModel.
 */
class ModuloCombustibleFilterModel
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
    public function __construct(ModuloCombustible $moduloCombustible = null)
    {
        if ($moduloCombustible !== null) {
            $this->id = $moduloCombustible->getId();

            if ($moduloCombustible->getAutobus()) {
                $this->estadoCivil  = $moduloCombustible->getAutobus();
            }
            if ($moduloCombustible->getChofer()) {
                $this->nacionalidad  = $moduloCombustible->getChofer();
            }
            if ($moduloCombustible->getCombustible()) {
                $this->nacionalidad  = $moduloCombustible->getCombustible();
            }
        }
    }

    /**
     * @return ModuloCombustible
     */
    public function getEntityData()
    {
        $moduloCombustible = new ModuloCombustible();

        if ($this->getAutobus() !== null) {
            $moduloCombustible->setAutobus($this->getAutobus());
        }
        if ($this->getChofer() !== null) {
            $moduloCombustible->setChofer($this->getChofer());
        }
        if ($this->getCombustible() !== null) {
            $moduloCombustible->setCombustible($this->getCombustible());
        }

        return $moduloCombustible;
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
