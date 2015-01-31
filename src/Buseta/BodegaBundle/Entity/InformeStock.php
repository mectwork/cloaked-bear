<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InformeStock
 *
 * @ORM\Table(name="d_informeStock")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\InformeStockRepository")
 */
class InformeStock
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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="movimientos")
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega", inversedBy="movimientos")
     */
    private $almacen;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadProductos", type="integer")
     */
    private $cantidadProductos;


    function __construct()
    {
        $this->cantidadProductos = 0;
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
     * Set cantidadProductos
     *
     * @param integer $cantidadProductos
     * @return InformeStock
     */
    public function setCantidadProductos($cantidadProductos)
    {
        $this->cantidadProductos = $cantidadProductos;
    
        return $this;
    }

    /**
     * Get cantidadProductos
     *
     * @return integer 
     */
    public function getCantidadProductos()
    {
        return $this->cantidadProductos;
    }

    /**
     * Set producto
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     * @return InformeStock
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

    /**
     * Set almacen
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     * @return InformeStock
     */
    public function setAlmacen(\Buseta\BodegaBundle\Entity\Bodega $almacen = null)
    {
        $this->almacen = $almacen;
    
        return $this;
    }

    /**
     * Get almacen
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega 
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }
}