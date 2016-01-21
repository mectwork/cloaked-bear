<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Buseta\BodegaBundle\Validator\Constraints\ValidarMaxMin;

/**
 * ProductoTope
 *
 * @ORM\Table(name="d_producto_tope")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\ProductoTopeRepository")
 * @UniqueEntity(fields={"producto", "almacen"}, message="Ya se encuentra registrado un Tope de producto con este mismo Producto y Almacen.")
 * @ValidarMaxMin()
 */
class ProductoTope
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
     * @var \Buseta\BodegaBundle\Entity\Producto
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto")
     * @ORM\JoinColumn(name="producto_id", nullable=false)
     * @Assert\NotBlank()
     */
    private $producto;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     * @ORM\JoinColumn(name="bodega_id", nullable=false)
     * @Assert\NotBlank()
     */
    private $almacen;

    /**
     * @var integer
     *
     * @ORM\Column(name="min", type="decimal", nullable=false)
     * @Assert\NotBlank()
     *
     */
    private $min;

    /**
     * @var integer
     *
     * @ORM\Column(name="max", type="decimal", nullable=false)
     * @Assert\NotBlank()
     */
    private $max;

    /**
     * @var string
     * @ORM\Column(name="comentarios", type="string", length=255, nullable=true)
     */
    private $comentarios;


    /**
     * Constructor.
     */
    public function __construct()
    {

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
     * Set id
     *
     * @param integer $id
     * @return ProductoTope
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set producto
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     * @return ProductoTope
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
     * @return ProductoTope
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

    /**
     * Set min
     *
     * @param integer $min
     * @return ProductoTope
     */
    public function setMin($min)
    {
        $this->min = $min;
    
        return $this;
    }

    /**
     * Get min
     *
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     * @return ProductoTope
     */
    public function setMax($max)
    {
        $this->max = $max;
    
        return $this;
    }

    /**
     * Get max
     *
     * @return integer 
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set comentarios
     *
     * @param string $comentarios
     * @return ProductoTope
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;
    
        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }
}
