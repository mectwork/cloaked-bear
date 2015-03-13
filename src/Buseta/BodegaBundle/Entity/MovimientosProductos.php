<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientosProductos.
 *
 * @ORM\Table(name="d_movimientosProductos")
 * @ORM\Entity
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
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Movimiento", inversedBy="movimientos_productos")
     */
    private $movimiento;

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
}
