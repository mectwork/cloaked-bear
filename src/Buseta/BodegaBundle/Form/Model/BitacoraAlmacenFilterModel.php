<?php
namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Producto;

class BitacoraAlmacenFilterModel
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $alma;

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
     * @return string
     */
    public function getAlma()
    {
        return $this->alma;
    }

    /**
     * @param string
     */
    public function setAlma($alma)
    {
        $this->alma = $alma;
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



}
