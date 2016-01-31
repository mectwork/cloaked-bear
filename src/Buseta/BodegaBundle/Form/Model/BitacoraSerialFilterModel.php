<?php
namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Producto;

class BitacoraSerialFilterModel
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $almacen;

    /**
     * @var \Buseta\BodegaBundle\Entity\CategoriaProducto
     */
    private $categoriaProd;

    /**
     * @var string
     */
    private $fechaMovimiento;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     */
    private $producto;

    /**
     * @var date
     */
    private $fechaInicio;

    /**
     * @var date
     */
    private $fechaFin;

    /**
     * @var string
     */
    private $tipoMovimiento;

    /**
     * @var string
     */
    private $serial;


    /**
     * @return string
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * @param string
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;
    }

    /**
     * @return string
     */
    public function getCategoriaProd()
    {
        return $this->categoriaProd;
    }

    /**
     * @param string
     */
    public function setCategoriaProd($categoriaProd)
    {
        $this->categoriaProd = $categoriaProd;
    }

    /**
     * @return string
     */
    public function getFechaMovimiento()
    {
        return $this->fechaMovimiento;
    }

    /**
     * @param string $fechaMovimiento
     */
    public function setFechaMovimiento($fechaMovimiento)
    {
        $this->fechaMovimiento = $fechaMovimiento;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
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
     * @return mixed
     */
    public function getTipoMovimiento()
    {
        return $this->tipoMovimiento;
    }

    public function setTipoMovimiento($tipoMovimiento)
    {
        $this->tipoMovimiento = $tipoMovimiento;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerial()
    {
        return $this->serial;
    }

    public function setSerial($serial)
    {
        $this->serial = $serial;
        return $this;
    }

}
