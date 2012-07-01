<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Autobus.
 *
 * @ORM\Table(name="d_configuracion_combustible")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\ConfiguracionCombustibleRepository")
 */
class ConfiguracionCombustible
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
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Combustible")
     */
    private $combustible;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $bodega;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto")
     */
    private $producto;

    public function __toString()
    {
        return $this->combustible;
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
     * Set combustible
     *
     * @param \Buseta\NomencladorBundle\Entity\Combustible $combustible
     * @return ConfiguracionCombustible
     */
    public function setCombustible(\Buseta\NomencladorBundle\Entity\Combustible $combustible = null)
    {
        $this->combustible = $combustible;
    
        return $this;
    }

    /**
     * Get combustible
     *
     * @return \Buseta\NomencladorBundle\Entity\Combustible 
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * Set bodega
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $bodega
     * @return ConfiguracionCombustible
     */
    public function setBodega(\Buseta\BodegaBundle\Entity\Bodega $bodega = null)
    {
        $this->bodega = $bodega;
    
        return $this;
    }

    /**
     * Get bodega
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega 
     */
    public function getBodega()
    {
        return $this->bodega;
    }

    /**
     * Set producto
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     * @return ConfiguracionCombustible
     */
    public function setProducto(\Buseta\BodegaBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;
    
        return $this;
    }

    /**
     * Get producto
     *
     * @return \Buseta\BodegaBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }
}