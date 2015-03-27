<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\AlbaranModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Albaran.
 *
 * @ORM\Table(name="d_albaran")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\AlbaranRepository")
 */
class Albaran
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
     * @var string
     *
     * @ORM\Column(name="estadoDocumento", type="string", nullable=false)
     */
    private $estadoDocumento;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompra")
     */
    private $pedidoCompra;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\AlbaranLinea", mappedBy="albaran", cascade={"all"})
     */
    private $albaranLinea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $updatedby;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $deletedby;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->albaranLinea = new \Doctrine\Common\Collections\ArrayCollection();
        $this->updated = new \DateTime();
        $this->deleted = false;
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
    public function addAlbaranLineon(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $albaranLinea->setAlbaran($this);

        $this->albaranLinea[] = $albaranLinea;

        return $this;
    }

    /**
     * Remove albaranLinea.
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     */
    public function removeAlbaranLineon(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $this->albaranLinea->removeElement($albaranLinea);
    }

    /**
     * Get albaranLinea.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbaranLineon()
    {
        return $this->albaranLinea;
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

        $this->albaranLinea[] = $albaranLinea;

        return $this;
    }

    /**
     * Remove albaranLinea.
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     */
    public function removeAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $this->albaranLinea->removeElement($albaranLinea);
    }

    /**
     * Get albaranLinea.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbaranLinea()
    {
        return $this->albaranLinea;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Albaran
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
     * @return Albaran
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
