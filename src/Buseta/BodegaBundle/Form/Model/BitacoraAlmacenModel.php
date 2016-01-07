<?php

namespace Buseta\BodegaBundle\Form\Model;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * BitacoraAlmacenModel
 *
 */
class BitacoraAlmacenModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $cantMovida;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $fechaMovimiento;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $bodega;

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
     * Constructor
     */
    public function __construct(BitacoraAlmacen $bitacoraalmacen = null)
    {
        if ($bitacoraalmacen !== null) {
            $this->id = $bitacoraalmacen->getId();
            $this->cantMovida =      $bitacoraalmacen->getCantidadMovida();
            $this->fechaMovimiento = $bitacoraalmacen->getFechaMovimiento();
            $this->producto = $bitacoraalmacen->getProducto();

        }
    }

    /**
     * @return BitacoraAlmacen
     */
    public function getEntityData()
    {
        $bitacoraalmacen = new BitacoraAlmacen();
        $bitacoraalmacen->getCantidadMovida($this->getCantMovida());
        $bitacoraalmacen->setFechaMovimiento($this->getFechaMovimiento());
        $bitacoraalmacen->setProducto($this->getProducto());


        return $bitacoraalmacen;
    }

    /**
     * @return string
     */
    public function getCantMovida()
    {
        return $this->cantMovida;
    }

    /**
     * @param string
     */
    public function setCantMovida($cantMovida)
    {
        $this->cantMovida = $cantMovida;
    }

    /**
     * @var date
     * @Assert\NotBlank()
     * @Assert\DateTime()
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
