<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\AlbaranModel;
use Buseta\BodegaBundle\Interfaces\DateTimeAwareInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Albaran.
 *
 * @ORM\Table(name="d_albaran")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\AlbaranRepository")
 */
class Albaran implements DateTimeAwareInterface
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
     * @ORM\Column(name="numeroReferencia", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $numeroReferencia;

    /**
     * @var string
     *
     * @ORM\Column(name="consecutivoCompra", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $consecutivoCompra;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="albaran")
     */
    private $tercero;

    /**
     * @var date
     *
     * @ORM\Column(name="fechaMovimiento", type="date", nullable=true)
     * @Assert\Date()
     */
    private $fechaMovimiento;

    /**
     * @var date
     *
     * @ORM\Column(name="fechaContable", type="date", nullable=true)
     * @Assert\Date()
     */
    private $fechaContable;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega", inversedBy="albaran")
     */
    private $almacen;

    /**
     * The Document Status indicates the status of a document at this time. To change the status of a document,
     * use one of the buttons usually located at the bottom of the document window.
     *
     * The allowed values for this list are:
     * ?? (Unknown)
     * AP (Accepted)
     * CH (Modified)
     * CL (Closed)
     * CO (Completed)
     * DR (Draft)
     * IN (Inactive)
     * IP (Under Way)
     * NA (Not Accepted)
     * PE (Accounting Error)
     * PO (Posted)
     * PR (Printed)
     * RE (Re-Opened)
     * TE (Transfer Error)
     * TR (Transferred)
     * VO (Voided)
     * WP (Not Paid)
     * XX (Procesando)
     *
     * @var string
     *
     * @ORM\Column(name="estadoDocumento", type="string", nullable=false)
     * @Assert\Choice(choices={"??","AP","CH","CL","CO","DR","IN","IP","NA","PE","PO","PR","RE","TE","TR","VO","WP","XX"})
     *
     */
    private $estadoDocumento;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompra")
     */
    private $pedidoCompra;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\AlbaranLinea", mappedBy="albaran", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private $albaranLineas;

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

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->albaranLineas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param AlbaranModel $model
     * @return Albaran
     */
    public function setModelData(AlbaranModel $model)
    {
        $this->id = $model->getId();
        $this->created = $model->getCreated();
        $this->createdby = $model->getCreatedby();
        $this->deleted = $model->getDeleted();
        $this->deletedby = $model->getDeletedby();
        $this->updated = $model->getUpdated();
        $this->updatedby = $model->getUpdatedby();

        $this->consecutivoCompra = $model->getConsecutivoCompra();
        $this->numeroReferencia = $model->getNumeroReferencia();
        $this->fechaMovimiento = $model->getFechaMovimiento();
        $this->fechaContable = $model->getFechaContable();
        $this->estadoDocumento = $model->getEstadoDocumento();

        if ($model->getTercero()) {
            $this->tercero  = $model->getTercero();
        }
        if ($model->getAlmacen()) {
            $this->almacen  = $model->getAlmacen();
        }
        if ($model->getPedidoCompra()) {
            $this->pedidoCompra  = $model->getPedidoCompra();
        }
        if (!$model->getAlbaranLinea()->isEmpty()) {
            $this->albaranLinea = $model->getAlbaranLinea();
        } else {
            $this->albaranLinea = new ArrayCollection();
        }

        return $this;
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
     * Set numeroReferencia.
     *
     * @param string $numeroReferencia
     *
     * @return Albaran
     */
    public function setNumeroReferencia($numeroReferencia)
    {
        $this->numeroReferencia = $numeroReferencia;

        return $this;
    }

    /**
     * Get numeroReferencia.
     *
     * @return string
     */
    public function getNumeroReferencia()
    {
        return $this->numeroReferencia;
    }

    /**
     * Set consecutivoCompra.
     *
     * @param string $consecutivoCompra
     *
     * @return Albaran
     */
    public function setConsecutivoCompra($consecutivoCompra)
    {
        $this->consecutivoCompra = $consecutivoCompra;

        return $this;
    }

    /**
     * Get consecutivoCompra.
     *
     * @return string
     */
    public function getConsecutivoCompra()
    {
        return $this->consecutivoCompra;
    }

    /**
     * Set fechaMovimiento.
     *
     * @param \DateTime $fechaMovimiento
     *
     * @return Albaran
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
     * Set fechaContable.
     *
     * @param \DateTime $fechaContable
     *
     * @return Albaran
     */
    public function setFechaContable($fechaContable)
    {
        $this->fechaContable = $fechaContable;

        return $this;
    }

    /**
     * Get fechaContable.
     *
     * @return \DateTime
     */
    public function getFechaContable()
    {
        return $this->fechaContable;
    }

    /**
     * Set estadoDocumento.
     *
     * @param string $estadoDocumento
     *
     * @return Albaran
     */
    public function setEstadoDocumento($estadoDocumento)
    {
        $this->estadoDocumento = $estadoDocumento;

        return $this;
    }

    /**
     * Get estadoDocumento.
     *
     * @return string
     */
    public function getEstadoDocumento()
    {
        return $this->estadoDocumento;
    }

    /**
     * Set tercero.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     *
     * @return Albaran
     */
    public function setTercero(\Buseta\BodegaBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * Set almacen.
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     *
     * @return Albaran
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
     * Set pedidoCompra.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     *
     * @return Albaran
     */
    public function setPedidoCompra(\Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra = null)
    {
        $this->pedidoCompra = $pedidoCompra;

        return $this;
    }

    /**
     * Get pedidoCompra.
     *
     * @return \Buseta\BodegaBundle\Entity\PedidoCompra
     */
    public function getPedidoCompra()
    {
        return $this->pedidoCompra;
    }

    /**
     * Add albaranLinea.
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     *
     * @return Albaran
     */
    public function addAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $albaranLinea->setAlbaran($this);

        $this->albaranLineas[] = $albaranLinea;

        return $this;
    }

    /**
     * Remove albaranLinea.
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     */
    public function removeAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $this->albaranLineas->removeElement($albaranLinea);
    }

    /**
     * Get albaranLinea.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbaranLineas()
    {
        return $this->albaranLineas;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Albaran
     */
    public function setCreated(\DateTime $created)
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
     * @return Albaran
     */
    public function setUpdated(\DateTime $updated)
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
     * @param boolean $deleted
     *
     * @return Albaran
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set createdby.
     *
     * @param \Buseta\SecurityBundle\Entity\User $createdby
     *
     * @return Albaran
     */
    public function setCreatedby(\Buseta\SecurityBundle\Entity\User $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby.
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updatedby.
     *
     * @param \Buseta\SecurityBundle\Entity\User $updatedby
     *
     * @return Albaran
     */
    public function setUpdatedby(\Buseta\SecurityBundle\Entity\User $updatedby = null)
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    /**
     * Get updatedby.
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * @return mixed
     */
    public function getDeletedby()
    {
        return $this->deletedby;
    }

    /**
     * @param mixed $deletedby
     */
    public function setDeletedby($deletedby)
    {
        $this->deletedby = $deletedby;
    }
}
