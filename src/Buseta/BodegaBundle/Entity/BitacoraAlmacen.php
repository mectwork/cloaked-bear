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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\CategoriaProducto")
     */
    private $categoriaProducto;

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
     * @ORM\Column(name="InventarioLinea", type="integer", nullable=true)
     */
    private $InventarioLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="MovimientoLinea", type="integer", nullable=true)
     */
    private $MovimientoLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="EntradaSalidaLinea", type="integer", nullable=true)
     */
    private $EntradaSalidaLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="ProduccionLinea", type="integer", nullable=true)
     */
    private $ProduccionLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="CantidadOrden", type="integer", nullable=true)
     */
    private $CantidadOrden;

    /**
     * @var integer
     *
     * @ORM\Column(name="ConsumoInterno", type="integer", nullable=true)
     */
    private $ConsumoInterno;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     */
    private $updatedby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
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
     * @return BitacoraAlmacen
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
     * @return BitacoraAlmacen
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
     * @return BitacoraAlmacen
     */
    public function setCantMovida($cantMovida)
    {
        $this->cantMovida = $cantMovida;

        return $this;
    }

    /**
     * Get cantMovida.
     *
     * @return integer
     */
    public function getCantMovida()
    {
        return $this->cantMovida;
    }

    /**
     * Set InventarioLinea.
     *
     * @param integer $inventarioLinea
     *
     * @return BitacoraAlmacen
     */
    public function setInventarioLinea($inventarioLinea)
    {
        $this->InventarioLinea = $inventarioLinea;

        return $this;
    }

    /**
     * Get InventarioLinea.
     *
     * @return integer
     */
    public function getInventarioLinea()
    {
        return $this->InventarioLinea;
    }

    /**
     * Set MovimientoLinea.
     *
     * @param integer $movimientoLinea
     *
     * @return BitacoraAlmacen
     */
    public function setMovimientoLinea($movimientoLinea)
    {
        $this->MovimientoLinea = $movimientoLinea;

        return $this;
    }

    /**
     * Get MovimientoLinea.
     *
     * @return integer
     */
    public function getMovimientoLinea()
    {
        return $this->MovimientoLinea;
    }

    /**
     * Set EntradaSalidaLinea.
     *
     * @param integer $entradaSalidaLinea
     *
     * @return BitacoraAlmacen
     */
    public function setEntradaSalidaLinea($entradaSalidaLinea)
    {
        $this->EntradaSalidaLinea = $entradaSalidaLinea;

        return $this;
    }

    /**
     * Get EntradaSalidaLinea.
     *
     * @return integer
     */
    public function getEntradaSalidaLinea()
    {
        return $this->EntradaSalidaLinea;
    }

    /**
     * Set ProduccionLinea.
     *
     * @param integer $produccionLinea
     *
     * @return BitacoraAlmacen
     */
    public function setProduccionLinea($produccionLinea)
    {
        $this->ProduccionLinea = $produccionLinea;

        return $this;
    }

    /**
     * Get ProduccionLinea.
     *
     * @return integer
     */
    public function getProduccionLinea()
    {
        return $this->ProduccionLinea;
    }

    /**
     * Set CantidadOrden.
     *
     * @param integer $cantidadOrden
     *
     * @return BitacoraAlmacen
     */
    public function setCantidadOrden($cantidadOrden)
    {
        $this->CantidadOrden = $cantidadOrden;

        return $this;
    }

    /**
     * Get CantidadOrden.
     *
     * @return integer
     */
    public function getCantidadOrden()
    {
        return $this->CantidadOrden;
    }

    /**
     * Set ConsumoInterno.
     *
     * @param integer $consumoInterno
     *
     * @return BitacoraAlmacen
     */
    public function setConsumoInterno($consumoInterno)
    {
        $this->ConsumoInterno = $consumoInterno;

        return $this;
    }

    /**
     * Get ConsumoInterno.
     *
     * @return integer
     */
    public function getConsumoInterno()
    {
        return $this->ConsumoInterno;
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
     * @return BitacoraAlmacen
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
     * @return BitacoraAlmacen
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
     * Set createdby.
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $createdby
     *
     * @return BitacoraAlmacen
     */
    public function setCreatedby(\HatueySoft\SecurityBundle\Entity\User $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby.
     *
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updatedby.
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $updatedby
     *
     * @return BitacoraAlmacen
     */
    public function setUpdatedby(\HatueySoft\SecurityBundle\Entity\User $updatedby = null)
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    /**
     * Get updatedby.
     *
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * Set deletedby.
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $deletedby
     *
     * @return BitacoraAlmacen
     */
    public function setDeletedby(\HatueySoft\SecurityBundle\Entity\User $deletedby = null)
    {
        $this->deletedby = $deletedby;

        return $this;
    }

    /**
     * Get deletedby.
     *
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getDeletedby()
    {
        return $this->deletedby;
    }

    /**
     * @return mixed
     */
    public function getCategoriaProducto()
    {
        return $this->categoriaProducto;
    }

    /**
     * @param mixed $categoriaProducto
     */
    public function setCategoriaProducto($categoriaProducto)
    {
        $this->categoriaProducto = $categoriaProducto;
    }
}
