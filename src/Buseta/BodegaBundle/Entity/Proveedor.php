<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor.
 *
 * @ORM\Table(name="d_proveedor")
 * @ORM\Entity
 */
class Proveedor
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
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="proveedor2")
     */
    private $tercero;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Moneda")
     */
    private $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="creditoLimite", type="decimal", nullable=true)
     */
    private $creditoLimite;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;


    /**
     * Set id
     *
     * @param integer $id
     * @return Proveedor
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set creditoLimite
     *
     * @param string $creditoLimite
     * @return Proveedor
     */
    public function setCreditoLimite($creditoLimite)
    {
        $this->creditoLimite = $creditoLimite;
    
        return $this;
    }

    /**
     * Get creditoLimite
     *
     * @return string 
     */
    public function getCreditoLimite()
    {
        return $this->creditoLimite;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Proveedor
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set tercero
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     * @return Proveedor
     */
    public function setTercero(\Buseta\BodegaBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;
    
        return $this;
    }

    /**
     * Get tercero
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero 
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * Set moneda
     *
     * @param \Buseta\NomencladorBundle\Entity\Moneda $moneda
     * @return Proveedor
     */
    public function setMoneda(\Buseta\NomencladorBundle\Entity\Moneda $moneda = null)
    {
        $this->moneda = $moneda;
    
        return $this;
    }

    /**
     * Get moneda
     *
     * @return \Buseta\NomencladorBundle\Entity\Moneda 
     */
    public function getMoneda()
    {
        return $this->moneda;
    }
}