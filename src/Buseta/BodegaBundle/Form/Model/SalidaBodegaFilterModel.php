<?php
namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Bodega;
use Buseta\BodegaBundle\Entity\Producto;
use Buseta\BusesBundle\Entity\Autobus;
use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\TallerBundle\Entity\OrdenTrabajo;

class SalidaBodegaFilterModel
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
     * @var Autobus
     */
    private $centroCosto;

    /**
     * @var Tercero
     */
    private $responsable;

    /**
     * @var date
     */
    private $fechaInicio;

    /**
     * @var date
     */
    private $fechaFin;

    /**
     * @var OrdenTrabajo
     */
    private $ordenTrabajo;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var Producto
     */
    private $producto;

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
     * @return Autobus
     */
    public function getCentroCosto()
    {
        return $this->centroCosto;
    }

    /**
     * @param Autobus $centroCosto
     */
    public function setCentroCosto($centroCosto)
    {
        $this->centroCosto = $centroCosto;
    }

    /**
     * @return Tercero
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param Tercero $responsable
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
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
     * @return OrdenTrabajo
     */
    public function getOrdenTrabajo()
    {
        return $this->ordenTrabajo;
    }

    /**
     * @param OrdenTrabajo $ordenTrabajo
     */
    public function setOrdenTrabajo($ordenTrabajo)
    {
        $this->ordenTrabajo = $ordenTrabajo;
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


} 