<?php
namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Bodega;
use Buseta\BodegaBundle\Entity\Producto;

class MovimientoFilterModel
{
    /**
     * @var Bodega
     */
    private $almacenOrigen;

    /**
     * @var Bodega
     */
    private $almacenDestino;

    /**
     * @var date
     */
    private $fechaInicio;

    /**
     * @var date
     */
    private $fechaFin;

    /**
     * @var Producto
     */
    private $producto;

    /**
     * @var string
     */
    private $estado;

    /**
     * @return Bodega
     */
    public function getAlmacenOrigen()
    {
        return $this->almacenOrigen;
    }

    /**
     * @param Bodega $almacenOrigen
     */
    public function setAlmacenOrigen($almacenOrigen)
    {
        $this->almacenOrigen = $almacenOrigen;
    }

    /**
     * @return Bodega
     */
    public function getAlmacenDestino()
    {
        return $this->almacenDestino;
    }

    /**
     * @param Bodega $almacenDestino
     */
    public function setAlmacenDestino($almacenDestino)
    {
        $this->almacenDestino = $almacenDestino;
    }

    /**
     * @return date
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param date $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * @return date
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * @param date $fechaFin
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * @return Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param Producto $producto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

}