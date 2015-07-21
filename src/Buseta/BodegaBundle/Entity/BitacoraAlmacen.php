<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BitacoraAlmacen.
 *
 * @ORM\Table(name="d_bitacora_almacen")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\BitacoraAlmacenRepository")
 */
class BitacoraAlmacen
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
     * The allowed values for this list are:
     * C+ (Customer Returns)
     * C- (Customer Shipment)
     * D+ (Internal Consumption +)
     * D- (Internal Consumption -)
     * I+ (Inventory In)
     * I- (Inventory Out)
     * M+ (Movement To)
     * M- (Movement From)
     * P+ (Production +)
     * P- (Production -)
     * V+ (Vendor Receipts)
     * V- (Vendor Returns)
     * W+ (Work Order +)
     * W- (Work Order -)
     *
     * @var string
     *
     * @ORM\Column(name="movement_type", type="string")
     *
     * @Assert\NotNull()
     * @Assert\Choice(choices={"C+","C-","D+","D-","I+","I-","M+","M-","P+","P-","V+","V-","W+","W-"})
     */
    private $tipoMovimiento;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     * @ORM\JoinColumn(name="warehouse_id")
     */
    private $almacen;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto")
     * @ORM\JoinColumn(name="product_id")
     *
     * @Assert\NotNull()
     */
    private $producto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="movement_date", type="date")
     * @Assert\Date()
     */
    private $fechaMovimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="movement_qty", type="integer", nullable=true)
     */
    private $cantidadMovida;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity_order", type="integer", nullable=true)
     */
    private $cantidadOrden;

    /**
     * @var \Buseta\BodegaBundle\Entity\InventarioFisicoLinea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\InventarioFisicoLinea")
     * @ORM\JoinColumn(name="inventoryline_id")
     */
    private $inventarioLinea;

    /**
     * @var \Buseta\BodegaBundle\Entity\MovimientosProductos
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\MovimientosProductos")
     * @ORM\JoinColumn(name="movementline_id")
     */
    private $movimientoLinea;

    /**
     * @var \Buseta\BodegaBundle\Entity\AlbaranLinea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\AlbaranLinea")
     * @ORM\JoinColumn(name="inoutline_id")
     */
    private $entradaSalidaLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="internal_consumptionline_id", type="integer", nullable=true)
     */
    private $consumoInterno;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \Buseta\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="createdby_id")
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var \Buseta\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="updatedby_id")
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @var \Buseta\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="deletedby_id")
     */
    private $deletedBy;


    function __construct()
    {
        $this->created = new \DateTime();
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
     * Set tipoMovimiento
     *
     * @param string $tipoMovimiento
     * @return BitacoraAlmacen
     */
    public function setTipoMovimiento($tipoMovimiento)
    {
        $this->tipoMovimiento = $tipoMovimiento;

        return $this;
    }

    /**
     * Get tipoMovimiento
     *
     * @return string
     */
    public function getTipoMovimiento()
    {
        return $this->tipoMovimiento;
    }

    /**
     * Set almacen
     *
     * @param string $almacen
     * @return BitacoraAlmacen
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen
     *
     * @return string
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * Set producto
     *
     * @param string $producto
     * @return BitacoraAlmacen
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return string
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set fechaMovimiento
     *
     * @param \DateTime $fechaMovimiento
     * @return BitacoraAlmacen
     */
    public function setFechaMovimiento($fechaMovimiento)
    {
        $this->fechaMovimiento = $fechaMovimiento;

        return $this;
    }

    /**
     * Get fechaMovimiento
     *
     * @return \DateTime
     */
    public function getFechaMovimiento()
    {
        return $this->fechaMovimiento;
    }

    /**
     * Set cantidadMovida
     *
     * @param integer $cantidadMovida
     * @return BitacoraAlmacen
     */
    public function setCantidadMovida($cantidadMovida)
    {
        $this->cantidadMovida = $cantidadMovida;

        return $this;
    }

    /**
     * Get cantidadMovida
     *
     * @return integer
     */
    public function getCantidadMovida()
    {
        return $this->cantidadMovida;
    }

    /**
     * Set cantidadOrden
     *
     * @param integer $cantidadOrden
     * @return BitacoraAlmacen
     */
    public function setCantidadOrden($cantidadOrden)
    {
        $this->cantidadOrden = $cantidadOrden;

        return $this;
    }

    /**
     * Get cantidadOrden
     *
     * @return integer
     */
    public function getCantidadOrden()
    {
        return $this->cantidadOrden;
    }

    /**
     * Set inventarioLinea
     *
     * @param string $inventarioLinea
     * @return BitacoraAlmacen
     */
    public function setInventarioLinea($inventarioLinea)
    {
        $this->inventarioLinea = $inventarioLinea;

        return $this;
    }

    /**
     * Get inventarioLinea
     *
     * @return string
     */
    public function getInventarioLinea()
    {
        return $this->inventarioLinea;
    }

    /**
     * Set movimientoLinea
     *
     * @param string $movimientoLinea
     * @return BitacoraAlmacen
     */
    public function setMovimientoLinea($movimientoLinea)
    {
        $this->movimientoLinea = $movimientoLinea;

        return $this;
    }

    /**
     * Get movimientoLinea
     *
     * @return string
     */
    public function getMovimientoLinea()
    {
        return $this->movimientoLinea;
    }

    /**
     * Set entradaSalidaLinea
     *
     * @param string $entradaSalidaLinea
     * @return BitacoraAlmacen
     */
    public function setEntradaSalidaLinea($entradaSalidaLinea)
    {
        $this->entradaSalidaLinea = $entradaSalidaLinea;

        return $this;
    }

    /**
     * Get entradaSalidaLinea
     *
     * @return string
     */
    public function getEntradaSalidaLinea()
    {
        return $this->entradaSalidaLinea;
    }

    /**
     * Set consumoInterno
     *
     * @param integer $consumoInterno
     * @return BitacoraAlmacen
     */
    public function setConsumoInterno($consumoInterno)
    {
        $this->consumoInterno = $consumoInterno;

        return $this;
    }

    /**
     * Get consumoInterno
     *
     * @return integer
     */
    public function getConsumoInterno()
    {
        return $this->consumoInterno;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return BitacoraAlmacen
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return BitacoraAlmacen
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return BitacoraAlmacen
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     * @return BitacoraAlmacen
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return BitacoraAlmacen
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deletedBy
     *
     * @param string $deletedBy
     * @return BitacoraAlmacen
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * Get deletedBy
     *
     * @return string
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }
}
