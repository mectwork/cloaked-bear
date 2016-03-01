<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Interfaces\DateTimeAwareInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Movimiento.
 *
 * @ORM\Table(name="d_movimiento")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\MovimientoRepository")
 */
class Movimiento implements DateTimeAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $almacenOrigen;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $almacenDestino;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaMovimiento", type="date")
     */
    private $fechaMovimiento;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\MovimientosProductos", mappedBy="movimiento", cascade={"all"})
     * @Assert\Valid()
     */
    private $movimientos_productos;

    /**
     * @var string
     *
     * @ORM\Column(name="moved_by", type="string", nullable=true)
     */
    private $movidoPor;

    /**
     * @var string
     *
     * @ORM\Column(name="document_status", type="string")
     */
    private $estadoDocumento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="createdBy_id")
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * HatueySoft\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="updatedBy_id")
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    private $deleted;

    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="deletedBy_id")
     */
    private $deletedBy;


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
     * Set fechaMovimiento.
     *
     * @param \DateTime $fechaMovimiento
     *
     * @return Movimiento
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
     * Set almacenOrigen.
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacenOrigen
     *
     * @return Movimiento
     */
    public function setAlmacenOrigen(\Buseta\BodegaBundle\Entity\Bodega $almacenOrigen = null)
    {
        $this->almacenOrigen = $almacenOrigen;

        return $this;
    }

    /**
     * Get almacenOrigen.
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getAlmacenOrigen()
    {
        return $this->almacenOrigen;
    }

    /**
     * Set almacenDestino.
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacenDestino
     *
     * @return Movimiento
     */
    public function setAlmacenDestino(\Buseta\BodegaBundle\Entity\Bodega $almacenDestino = null)
    {
        $this->almacenDestino = $almacenDestino;

        return $this;
    }

    /**
     * Get almacenDestino.
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getAlmacenDestino()
    {
        return $this->almacenDestino;
    }

    /**
     * Add movimientos_productos.
     *
     * @param \Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos
     *
     * @return Movimiento
     */
    public function addMovimientosProducto(\Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos)
    {
        $movimientosProductos->setMovimiento($this);

        $this->movimientos_productos[] = $movimientosProductos;

        return $this;
    }

    /**
     * Remove movimientos_productos.
     *
     * @param \Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos
     */
    public function removeMovimientosProducto(\Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos)
    {
        $this->movimientos_productos->removeElement($movimientosProductos);
    }

    /**
     * Get movimientos_productos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientosProductos()
    {
        return $this->movimientos_productos;
    }

    /**
     * Set estado_documento
     *
     * @param string $estadoDocumento
     *
     * @return Movimiento
     */
    public function setEstadoDocumento($estadoDocumento)
    {
        $this->estadoDocumento = $estadoDocumento;

        return $this;
    }

    /**
     * Get estado_documento
     *
     * @return string
     */
    public function getEstadoDocumento()
    {
        return $this->estadoDocumento;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movimientos_productos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set movidoPor
     *
     * @param string $movidoPor
     *
     * @return Movimiento
     */
    public function setMovidoPor($movidoPor)
    {
        $this->movidoPor = $movidoPor;

        return $this;
    }

    /**
     * Get movidoPor
     *
     * @return string
     */
    public function getMovidoPor()
    {
        return $this->movidoPor;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Movimiento
     */
    public function setCreated(\DateTime $created)
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
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Movimiento
     */
    public function setUpdated(\DateTime $updated)
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
     * Set deleted
     *
     * @param \DateTime $deleted
     *
     * @return Movimiento
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
     * Set createdBy
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $createdBy
     *
     * @return Movimiento
     */
    public function setCreatedBy(\HatueySoft\SecurityBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $updatedBy
     *
     * @return Movimiento
     */
    public function setUpdatedBy(\HatueySoft\SecurityBundle\Entity\User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set deletedBy
     *
     * @param \HatueySoft\SecurityBundle\Entity\User $deletedBy
     *
     * @return Movimiento
     */
    public function setDeletedBy(\HatueySoft\SecurityBundle\Entity\User $deletedBy = null)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * Get deletedBy
     *
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }
}
