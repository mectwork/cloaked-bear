<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Autobus.
 *
 * @ORM\Table(name="d_lista_negra_combustible")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\ListaNegraCombustibleRepository")
 */
class ListaNegraCombustible
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
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     */
    private $autobus;

    /**
     * @var date
     *
     * @ORM\Column(name="fechaInicio", type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $fechaInicio;

    /**
     * @var date
     *
     * @ORM\Column(name="fechaFinal", type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $fechaFinal;



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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return ListaNegraCombustible
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    
        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     * @return ListaNegraCombustible
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
    
        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return ListaNegraCombustible
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