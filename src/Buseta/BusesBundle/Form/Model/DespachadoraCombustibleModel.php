<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Chofer;
use Buseta\BusesBundle\Entity\DespachadoraCombustible;
use Buseta\BusesBundle\Form\Model\ChoferInDespachadoraCombustible;
use Doctrine\ORM\Mapping as ORM;

use Buseta\BusesBundle\Validator\Constraints as BusetaBusesAssert;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * DespachadoraCombustibleModel
 * @BusetaBusesAssert\CapacidadTanqueValido
 */
class DespachadoraCombustibleModel
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
     * @var integer
     * @Assert\NotBlank()
     */
    private $cantidadLibros;

    /**
     * @var ChoferInDespachadoraCombustible
     * @Assert\Valid
     */
    private $chofer;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     */
    private $autobus;

    /**
     * @return DespachadoraCombustible
     */
    public function getEntityData()
    {
        $despachadoraCombustible = new DespachadoraCombustible();
        $despachadoraCombustible->setCantidadLibros($this->getCantidadLibros());

        if ($this->getCombustible() !== null) {
            $despachadoraCombustible->setCombustible($this->getCombustible());
        }
        if ($this->getChofer() !== null) {
            $despachadoraCombustible->setChofer($this->getChofer()->getChofer());
        }
        if ($this->getAutobus() !== null) {
            $despachadoraCombustible->setAutobus($this->getAutobus());
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
     * @return ConfiguracionCombustible
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param ConfiguracionCombustible $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
    }

    /**
     * @return int
     */
    public function getCantidadLibros()
    {
        return $this->cantidadLibros;
    }

    /**
     * @param int $cantidadLibros
     */
    public function setCantidadLibros($cantidadLibros)
    {
        $this->cantidadLibros = $cantidadLibros;
    }

    /**
     * @param mixed $chofer
     */
    public function setChofer($chofer)
    {
        if($chofer instanceof ChoferInDespachadoraCombustible){
            $this->chofer = $chofer;
        }else if($chofer instanceof Chofer){
            $choferInDespachadoraCombustible = new ChoferInDespachadoraCombustible();
            $choferInDespachadoraCombustible->setChofer($chofer);
            $this->chofer = $choferInDespachadoraCombustible;
        }
    }

    /**
     * @return ChoferInDespachadoraCombustible
     */
    public function getChofer()
    {
        return $this->chofer;
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

}