<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Buseta\BodegaBundle\Validator\Constraints\ValidarSerial;

/**
 * MovimientosProductos.
 * @ValidarSerial()
 * @ORM\Table(name="d_movimiento_producto")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\MovimientosProductosRepository")
 */
class MovimientosProductos
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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto")
     */
    private $producto;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     * @Assert\NotBlank
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Movimiento", inversedBy="movimientos_productos")
     */
    private $movimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="seriales", type="string", nullable=true)
     */
    private $seriales;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cantidad.
     *
     * @param integer $cantidad
     *
     * @return MovimientosProductos
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad.
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set producto.
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     *
     * @return MovimientosProductos
     */
    public function setProducto(\Buseta\BodegaBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto.
     *
     * @return \Buseta\BodegaBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set movimiento.
     *
     * @param \Buseta\BodegaBundle\Entity\Movimiento $movimiento
     *
     * @return MovimientosProductos
     */
    public function setMovimiento(\Buseta\BodegaBundle\Entity\Movimiento $movimiento = null)
    {
        $this->movimiento = $movimiento;

        return $this;
    }

    /**
     * Get movimiento.
     *
     * @return \Buseta\BodegaBundle\Entity\Movimiento
     */
    public function getMovimiento()
    {
        return $this->movimiento;
    }

    /**
     * @return string
     */
    public function getSeriales()
    {
        return $this->seriales;
    }

    /**
     * @param string $seriales
     *
     * @return SalidaBodegaProducto
     */
    public function setSeriales($seriales)
    {
        $this->seriales = $seriales;
        return $this;
    }
}
