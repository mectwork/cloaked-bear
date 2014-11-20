<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Compra
 *
 * @ORM\Table(name="d_compra")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\CompraRepository")
 */
class Compra
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
     * @var string
     *
     * @ORM\Column(name="numero", type="string", nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_factura_proveedor", type="string", nullable=false)
     */
    private $numero_factura_proveedor;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="compras")
     */
    private $tercero;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus", inversedBy="compras")
     */
    private $centro_costo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\Linea", mappedBy="compra", cascade={"all"})
     */
    private $lineas;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="orden_prioridad", type="string", nullable=true)
     */
    private $orden_prioridad;

    /**
     * @var date
     *
     * @ORM\Column(name="fecha_pedido", type="date")
     * @Assert\Date()
     */
    private $fecha_pedido;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\FormaPago")
     */
    private $forma_pago;

    /**
     * @var string
     *
     * @ORM\Column(name="moneda", type="string", nullable=false)
     */
    private $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="condiciones_pago", type="string", nullable=false)
     */
    private $condiciones_pago;

    /**
     * @var float
     *
     * @ORM\Column(name="total_libre_impuesto", type="decimal", scale=2)
     */
    private $importe_libre_impuesto;

    /**
     * @var float
     *
     * @ORM\Column(name="total_con_impuesto", type="decimal", scale=2)
     */
    private $importe_con_impuesto;

    /**
     * @var float
     *
     * @ORM\Column(name="total_general", type="decimal", scale=2)
     */
    private $importe_general;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", nullable=false)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="mecanico_solicita", type="string", nullable=false)
     */
    private $mecanico_solicita;

    /**
     * @param string $orden_prioridad
     */
    public function setOrdenPrioridad($orden_prioridad)
    {
        $this->orden_prioridad = $orden_prioridad;
    }

    /**
     * @return string
     */
    public function getOrdenPrioridad()
    {
        return $this->orden_prioridad;
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
     * Set numero
     *
     * @param string $numero
     * @return Compra
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }
    
    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Compra
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha_pedido
     *
     * @param \DateTime $fechaPedido
     * @return Compra
     */
    public function setFechaPedido($fechaPedido)
    {
        $this->fecha_pedido = $fechaPedido;
    
        return $this;
    }

    /**
     * Get fecha_pedido
     *
     * @return \DateTime 
     */
    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    /**
     * Set moneda
     *
     * @param string $moneda
     * @return Compra
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;
    
        return $this;
    }

    /**
     * Get moneda
     *
     * @return string 
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set condiciones_pago
     *
     * @param string $condicionesPago
     * @return Compra
     */
    public function setCondicionesPago($condicionesPago)
    {
        $this->condiciones_pago = $condicionesPago;
    
        return $this;
    }

    /**
     * Get condiciones_pago
     *
     * @return string 
     */
    public function getCondicionesPago()
    {
        return $this->condiciones_pago;
    }

    /**
     * Set importe_libre_impuesto
     *
     * @param float $importeLibreImpuesto
     * @return Compra
     */
    public function setImporteLibreImpuesto($importeLibreImpuesto)
    {
        $this->importe_libre_impuesto = $importeLibreImpuesto;
    
        return $this;
    }

    /**
     * Get importe_libre_impuesto
     *
     * @return float 
     */
    public function getImporteLibreImpuesto()
    {
        return $this->importe_libre_impuesto;
    }

    /**
     * Set importe_con_impuesto
     *
     * @param float $importeConImpuesto
     * @return Compra
     */
    public function setImporteConImpuesto($importeConImpuesto)
    {
        $this->importe_con_impuesto = $importeConImpuesto;
    
        return $this;
    }

    /**
     * Get importe_con_impuesto
     *
     * @return float 
     */
    public function getImporteConImpuesto()
    {
        return $this->importe_con_impuesto;
    }

    /**
     * Set importe_general
     *
     * @param float $importeGeneral
     * @return Compra
     */
    public function setImporteGeneral($importeGeneral)
    {
        $this->importe_general = $importeGeneral;
    
        return $this;
    }

    /**
     * Get importe_general
     *
     * @return float 
     */
    public function getImporteGeneral()
    {
        return $this->importe_general;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Compra
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set tercero
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     * @return Compra
     */
    public function setTercero(\Buseta\BodegaBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;
    
        return $this;
    }

    /**
     * Get tercero
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero 
     */
    public function getTercero()
    {
        return $this->tercero;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lineas = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add lineas
     *
     * @param \Buseta\TallerBundle\Entity\Linea $lineas
     * @return Compra
     */
    public function addLinea(\Buseta\TallerBundle\Entity\Linea $lineas)
    {
        $lineas->setCompra($this);

        $this->lineas[] = $lineas;
    
        return $this;
    }

    /**
     * Remove lineas
     *
     * @param \Buseta\TallerBundle\Entity\Linea $lineas
     */
    public function removeLinea(\Buseta\TallerBundle\Entity\Linea $lineas)
    {
        $this->lineas->removeElement($lineas);
    }

    /**
     * Get lineas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLineas()
    {
        return $this->lineas;
    }

    /**
     * Set numero_factura_proveedor
     *
     * @param string $numeroFacturaProveedor
     * @return Compra
     */
    public function setNumeroFacturaProveedor($numeroFacturaProveedor)
    {
        $this->numero_factura_proveedor = $numeroFacturaProveedor;
    
        return $this;
    }

    /**
     * Get numero_factura_proveedor
     *
     * @return string 
     */
    public function getNumeroFacturaProveedor()
    {
        return $this->numero_factura_proveedor;
    }

    /**
     * Set mecanico_solicita
     *
     * @param string $mecanicoSolicita
     * @return Compra
     */
    public function setMecanicoSolicita($mecanicoSolicita)
    {
        $this->mecanico_solicita = $mecanicoSolicita;
    
        return $this;
    }

    /**
     * Get mecanico_solicita
     *
     * @return string 
     */
    public function getMecanicoSolicita()
    {
        return $this->mecanico_solicita;
    }

    /**
     * Set centro_costo
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $centroCosto
     * @return Compra
     */
    public function setCentroCosto(\Buseta\BusesBundle\Entity\Autobus $centroCosto = null)
    {
        $this->centro_costo = $centroCosto;
    
        return $this;
    }

    /**
     * Get centro_costo
     *
     * @return \Buseta\BusesBundle\Entity\Autobus 
     */
    public function getCentroCosto()
    {
        return $this->centro_costo;
    }

    /**
     * Set forma_pago
     *
     * @param \Buseta\NomencladorBundle\Entity\FormaPago $formaPago
     * @return Compra
     */
    public function setFormaPago(\Buseta\NomencladorBundle\Entity\FormaPago $formaPago = null)
    {
        $this->forma_pago = $formaPago;
    
        return $this;
    }

    /**
     * Get forma_pago
     *
     * @return \Buseta\NomencladorBundle\Entity\FormaPago 
     */
    public function getFormaPago()
    {
        return $this->forma_pago;
    }
}