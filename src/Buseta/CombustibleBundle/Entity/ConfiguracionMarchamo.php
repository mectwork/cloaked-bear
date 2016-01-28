<?php

namespace Buseta\CombustibleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConfiguracionMarchamo
 *
 * @ORM\Table(name="conf_marchamo")
 * @ORM\Entity(repositoryClass="Buseta\CombustibleBundle\Entity\Repository\ConfiguracionMarchamoRepository")
 */
class ConfiguracionMarchamo
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
     * @var \Buseta\BodegaBundle\Entity\Bodega
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     * @Assert\NotNull
     */
    private $bodega;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto")
     * @Assert\NotNull
     */
    private $producto;

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
     * Set bodega
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $bodega
     * @return ConfiguracionMarchamo
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
     * @return ConfiguracionMarchamo
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
