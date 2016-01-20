<?php
namespace Buseta\BodegaBundle\Form\Model;

class AlbaranFilterModel
{
    /**
     * @var string
     */
    private $numeroReferencia;

    /**
     * @var string
     */
    private $consecutivoCompra;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $almacen;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     */
    private $tercero;

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
    private $estado;

    /**
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;
    }

    /**
     * @return string
     */
    public function getConsecutivoCompra()
    {
        return $this->consecutivoCompra;
    }

    /**
     * @param string $consecutivoCompra
     */
    public function setConsecutivoCompra($consecutivoCompra)
    {
        $this->consecutivoCompra = $consecutivoCompra;
    }

    /**
     * @return string
     */
    public function getNumeroReferencia()
    {
        return $this->numeroReferencia;
    }

    /**
     * @param string $numeroReferencia
     */
    public function setNumeroReferencia($numeroReferencia)
    {
        $this->numeroReferencia = $numeroReferencia;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
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