<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ModuloCombustible.
 *
 * @ORM\Table(name="d_modulo_combustible")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\ModuloCombustibleRepository")
 */
class ModuloCombustible
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
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\ConfiguracionCombustible")
     */
    private $combustible;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadLibros", type="integer")
     * @Assert\NotBlank()
     */
    private $cantidadLibros;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Chofer")
     */
    private $chofer;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     */
    private $autobus;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cantidadLibros
     *
     * @param integer $cantidadLibros
     * @return ModuloCombustible
     */
    public function setCantidadLibros($cantidadLibros)
    {
        $this->cantidadLibros = $cantidadLibros;
    
        return $this;
    }

    /**
     * Get cantidadLibros
     *
     * @return integer 
     */
    public function getCantidadLibros()
    {
        return $this->cantidadLibros;
    }

    /**
     * Set combustible
     *
     * @param \Buseta\BusesBundle\Entity\ConfiguracionCombustible $combustible
     * @return ModuloCombustible
     */
    public function setCombustible(\Buseta\BusesBundle\Entity\ConfiguracionCombustible $combustible = null)
    {
        $this->combustible = $combustible;
    
        return $this;
    }

    /**
     * Get combustible
     *
     * @return \Buseta\BusesBundle\Entity\ConfiguracionCombustible 
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * Set chofer
     *
     * @param \Buseta\BusesBundle\Entity\Chofer $chofer
     * @return ModuloCombustible
     */
    public function setChofer(\Buseta\BusesBundle\Entity\Chofer $chofer = null)
    {
        $this->chofer = $chofer;
    
        return $this;
    }

    /**
     * Get chofer
     *
     * @return \Buseta\BusesBundle\Entity\Chofer 
     */
    public function getChofer()
    {
        return $this->chofer;
    }

    /**
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return ModuloCombustible
     */
    public function setAutobus(\Buseta\BusesBundle\Entity\Autobus $autobus = null)
    {
        $this->autobus = $autobus;
    
        return $this;
    }

    /**
     * Get autobus
     *
     * @return \Buseta\BusesBundle\Entity\Autobus 
     */
    public function getAutobus()
    {
        return $this->autobus;
    }
}