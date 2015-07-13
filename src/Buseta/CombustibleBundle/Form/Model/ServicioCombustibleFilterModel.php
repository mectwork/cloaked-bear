<?php

namespace Buseta\CombustibleBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Buseta\CombustibleBundle\Entity\ServicioCombustible;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ServicioCombustibleFilterModel.
 */
class ServicioCombustibleFilterModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Buseta\CombustibleBundle\Entity\ConfiguracionCombustible
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
    public function __construct(ServicioCombustible $servicioCombustible = null)
    {
        if ($servicioCombustible !== null) {
            $this->id = $servicioCombustible->getId();

            if ($servicioCombustible->getAutobus()) {
                $this->estadoCivil  = $servicioCombustible->getAutobus();
            }
            if ($servicioCombustible->getChofer()) {
                $this->nacionalidad  = $servicioCombustible->getChofer();
            }
            if ($servicioCombustible->getCombustible()) {
                $this->nacionalidad  = $servicioCombustible->getCombustible();
            }
        }
    }

    /**
     * @return ServicioCombustible
     */
    public function getEntityData()
    {
        $servicioCombustible = new ServicioCombustible();

        if ($this->getAutobus() !== null) {
            $servicioCombustible->setAutobus($this->getAutobus());
        }
        if ($this->getChofer() !== null) {
            $servicioCombustible->setChofer($this->getChofer());
        }
        if ($this->getCombustible() !== null) {
            $servicioCombustible->setCombustible($this->getCombustible());
        }

        return $servicioCombustible;
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
     * @return \Buseta\CombustibleBundle\Entity\ConfiguracionCombustible
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param \Buseta\CombustibleBundle\Entity\ConfiguracionCombustible $combustible
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
