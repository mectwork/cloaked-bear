<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BitacoraSeriales.
 *
 * @ORM\Table(name="d_bitacora_serial")
 * @ORM\Entity
 */
class BitacoraSerial
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
     * @ORM\Column(name="tipoMovimiento", type="string", nullable=true)
     */
    private $tipoMovimiento;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $almacen;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto")
     */
    private $producto;

    /**
     * @var date
     *
     * @ORM\Column(name="fechaMovimiento", type="date")
     * @Assert\Date()
     */
    private $fechaMovimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantMovida", type="integer", nullable=true)
     */
    private $cantMovida;

    /**
     * @var integer
     *
     * @ORM\Column(name="inventarioLinea", type="integer", nullable=true)
     */
    private $inventarioLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="movimientoLinea", type="integer", nullable=true)
     */
    private $movimientoLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="entradaSalidaLinea", type="integer", nullable=true)
     */
    private $entradaSalidaLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="produccionLinea", type="integer", nullable=true)
     */
    private $produccionLinea;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\BitacoraAlmacen")
     */
    private $bitacoraAlmacen;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var string
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     *
     */
    private $updatedby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     *
     */
    private $deletedby;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

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
     * Set tipoMovimiento.
     *
     * @param string $tipoMovimiento
     *
     * @return BitacoraSerial
     */
    public function setTipoMovimiento($tipoMovimiento)
    {
        $this->tipoMovimiento = $tipoMovimiento;

        return $this;
    }

    /**
     * Get tipoMovimiento.
     *
     * @return string
     */
    public function getTipoMovimiento()
    {
        return $this->tipoMovimiento;
    }

    /**
     * Set fechaMovimiento.
     *
     * @param \DateTime $fechaMovimiento
     *
     * @return BitacoraSerial
     */
    public function setFechaMovimiento($fechaMovimiento)
    {
        $this->fechaMovimiento = $fechaMovimiento;

        return $this;
    }

    /**
     * Get fechaMovimiento.
     *
     * @return \DateTime
     */
    public function getFechaMovimiento()
    {
        return $this->fechaMovimiento;
    }

    /**
     * Set cantMovida.
     *
     * @param integer $cantMovida
     *
     * @return BitacoraSerial
     */
    public function setCantidadMovida($cantMovida)
    {
        $this->cantMovida = $cantMovida;

        return $this;
    }

    /**
     * Get cantMovida.
     *
     * @return integer
     */
    public function getCantidadMovida()
    {
        return $this->cantMovida;
    }

    /**
     * Set InventarioLinea.
     *
     * @param integer $inventarioLinea
     *
     * @return BitacoraSerial
     */
    public function setInventarioLinea($inventarioLinea)
    {
        $this->inventarioLinea = $inventarioLinea;

        return $this;
    }

    /**
     * Get InventarioLinea.
     *
     * @return integer
     */
    public function getInventarioLinea()
    {
        return $this->inventarioLinea;
    }

    /**
     * Set MovimientoLinea.
     *
     * @param integer $movimientoLinea
     *
     * @return BitacoraSerial
     */
    public function setMovimientoLinea($movimientoLinea)
    {
        $this->movimientoLinea = $movimientoLinea;

        return $this;
    }

    /**
     * Get MovimientoLinea.
     *
     * @return integer
     */
    public function getMovimientoLinea()
    {
        return $this->movimientoLinea;
    }

    /**
     * Set EntradaSalidaLinea.
     *
     * @param integer $entradaSalidaLinea
     *
     * @return BitacoraSerial
     */
    public function setEntradaSalidaLinea($entradaSalidaLinea)
    {
        $this->entradaSalidaLinea = $entradaSalidaLinea;

        return $this;
    }

    /**
     * Get EntradaSalidaLinea.
     *
     * @return integer
     */
    public function getEntradaSalidaLinea()
    {
        return $this->entradaSalidaLinea;
    }

    /**
     * Set ProduccionLinea.
     *
     * @param integer $produccionLinea
     *
     * @return BitacoraSerial
     */
    public function setProduccionLinea($produccionLinea)
    {
        $this->produccionLinea = $produccionLinea;

        return $this;
    }

    /**
     * Get ProduccionLinea.
     *
     * @return integer
     */
    public function getProduccionLinea()
    {
        return $this->produccionLinea;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return BitacoraAlmacen
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return BitacoraAlmacen
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return BitacoraAlmacen
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set almacen.
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     *
     * @return BitacoraSerial
     */
    public function setAlmacen(\Buseta\BodegaBundle\Entity\Bodega $almacen = null)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen.
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * Set producto.
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     *
     * @return BitacoraSerial
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
     * Set almacen.
     *
     * @param \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacoraAlmacen
     *
     * @return BitacoraSerial
     */
    public function setBitacoraAlmacen(\Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacoraAlmacen = null)
    {
        $this->bitacoraAlmacen = $bitacoraAlmacen;

        return $this;
    }

    /**
     * Get bitacoraAlmacen.
     *
     * @return \Buseta\BodegaBundle\Entity\BitacoraAlmacen
     */
    public function getBitacoraAlmacen()
    {
        return $this->bitacoraAlmacen;
    }

    /**
     * Set createdby.
     *
     * @param @return string
     *
     * @return BitacoraSerial
     */
    public function setCreatedby( $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby.
     *
     * @return string
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     * @return BitacoraSerial
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
        return $this->updatedby;
    }

    /**
     * Set deletedBy
     *
     * @param string $deletedBy
     * @return BitacoraSerial
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedby = $deletedBy;

        return $this;
    }

    /**
     * Get deletedBy
     *
     * @return string
     */
    public function getDeletedBy()
    {
        return $this->deletedby;
    }

}
