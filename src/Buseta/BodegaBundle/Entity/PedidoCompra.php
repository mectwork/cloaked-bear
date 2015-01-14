<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PedidoCompra
 *
 * @ORM\Table(name="d_pedido_compra")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\PedidoCompraRepository")
 */
class PedidoCompra
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
     * @ORM\Column(name="numero_documento", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $numero_documento;

    /**
     * @var string
     *
     * @ORM\Column(name="consecutivo_compra", type="string", nullable=false)
     */
    private $consecutivo_compra;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="pedidoCompra")
     */
    private $tercero;

    /**
     * @var date
     *
     * @ORM\Column(name="fecha_pedido", type="date")
     * @Assert\Date()
     */
    private $fecha_pedido;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega", inversedBy="pedidoCompra")
     */
    private $almacen;

    /**
     * @var string
     *
     * @ORM\Column(name="moneda", type="string", nullable=false)
     */
    private $moneda;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\FormaPago")
     */
    private $forma_pago;

    /**
     * @var string
     *
     * @ORM\Column(name="condiciones_pago", type="string", nullable=false)
     */
    private $condiciones_pago;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_documento", type="string", nullable=false)
     */
    private $estado_documento;

    /**
     * @var float
     *
     * @ORM\Column(name="importe_total_lineas", type="decimal", scale=2)
     */
    private $importe_total_lineas;

    /**
     * @var float
     *
     * @ORM\Column(name="importe_total", type="decimal", scale=2)
     */
    private $importe_total;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompraLinea", mappedBy="pedidoCompra", cascade={"all"})
     */
    private $pedido_compra_lineas;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedido_compra_lineas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->importe_total_lineas = 0;
        $this->importe_total = 0;
        $this->estado_documento = 'Borrador';
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
     * Set numero_documento
     *
     * @param string $numeroDocumento
     * @return PedidoCompra
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numero_documento = $numeroDocumento;
    
        return $this;
    }

    /**
     * Get numero_documento
     *
     * @return string 
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
    }

    /**
     * Set consecutivo_compra
     *
     * @param string $consecutivoCompra
     * @return PedidoCompra
     */
    public function setConsecutivoCompra($consecutivoCompra)
    {
        $this->consecutivo_compra = $consecutivoCompra;
    
        return $this;
    }

    /**
     * Get consecutivo_compra
     *
     * @return string 
     */
    public function getConsecutivoCompra()
    {
        return $this->consecutivo_compra;
    }

    /**
     * Set fecha_pedido
     *
     * @param \DateTime $fechaPedido
     * @return PedidoCompra
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
     * @return PedidoCompra
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
     * @return PedidoCompra
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
     * Set estado_documento
     *
     * @param string $estadoDocumento
     * @return PedidoCompra
     */
    public function setEstadoDocumento($estadoDocumento)
    {
        $this->estado_documento = $estadoDocumento;
    
        return $this;
    }

    /**
     * Get estado_documento
     *
     * @return string 
     */
    public function getEstadoDocumento()
    {
        return $this->estado_documento;
    }

    /**
     * Set importe_total_lineas
     *
     * @param string $importeTotalLineas
     * @return PedidoCompra
     */
    public function setImporteTotalLineas($importeTotalLineas)
    {
        $this->importe_total_lineas = $importeTotalLineas;
    
        return $this;
    }

    /**
     * Get importe_total_lineas
     *
     * @return string 
     */
    public function getImporteTotalLineas()
    {
        return $this->importe_total_lineas;
    }

    /**
     * Set importe_total
     *
     * @param string $importeTotal
     * @return PedidoCompra
     */
    public function setImporteTotal($importeTotal)
    {
        $this->importe_total = $importeTotal;
    
        return $this;
    }

    /**
     * Get importe_total
     *
     * @return string 
     */
    public function getImporteTotal()
    {
        return $this->importe_total;
    }

    /**
     * Set tercero
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     * @return PedidoCompra
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
     * Set almacen
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     * @return PedidoCompra
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
     * Set forma_pago
     *
     * @param \Buseta\NomencladorBundle\Entity\FormaPago $formaPago
     * @return PedidoCompra
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



    /**
     * Add pedido_compra_lineas
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     * @return PedidoCompra
     */
    public function addPedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $pedidoCompraLineas->setPedidoCompra($this);

        $this->pedido_compra_lineas[] = $pedidoCompraLineas;
    
        return $this;
    }

    /**
     * Remove pedido_compra_lineas
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     */
    public function removePedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $this->pedido_compra_lineas->removeElement($pedidoCompraLineas);
    }

    /**
     * Get pedido_compra_lineas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPedidoCompraLineas()
    {
        return $this->pedido_compra_lineas;
    }
}