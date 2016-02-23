<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Albaran;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Albaran Model
 *
 */
class AlbaranModel
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $numeroReferencia;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $consecutivoCompra;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     * @Assert\NotBlank()
     */
    private $tercero;

    /**
     * @var date
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaMovimiento;

    /**
     * @var date
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaContable;

    /**
     * @Assert\NotBlank()
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $almacen;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $estadoDocumento = 'BO';

    /**
     * @var \Buseta\BodegaBundle\Entity\PedidoCompra
     */
    private $pedidoCompra;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $albaranLinea;

    /**
     * @var \DateTime
     *
     */
    private $created;

    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     */
    private $updated;

    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     */
    private $updatedby;

    /**
     * @var boolean
     *
     */
    private $deleted;

    /**
     * @var \HatueySoft\SecurityBundle\Entity\User
     *
     */
    private $deletedby;

    /**
     * Constructor
     */
    public function __construct(Albaran $albaran = null)
    {
        $this->albaranLinea = new \Doctrine\Common\Collections\ArrayCollection();

        if ($albaran !== null) {
            $this->id = $albaran->getId();
/*            $this->created = $albaran->getCreated();
            $this->createdby = $albaran->getCreatedby();
            $this->deleted = $albaran->getDeleted();
            $this->deletedby = $albaran->getDeletedby();
            $this->updated = $albaran->getUpdated();
            $this->updatedby = $albaran->getUpdatedby();*/
            $this->consecutivoCompra = $albaran->getConsecutivoCompra();
            $this->numeroReferencia = $albaran->getNumeroReferencia();
            $this->fechaMovimiento = $albaran->getFechaMovimiento();
            $this->fechaContable = $albaran->getFechaContable();
            $this->estadoDocumento = $albaran->getEstadoDocumento();

            if ($albaran->getTercero()) {
                $this->tercero  = $albaran->getTercero();
            }
            if ($albaran->getAlmacen()) {
                $this->almacen  = $albaran->getAlmacen();
            }
            if ($albaran->getPedidoCompra()) {
                $this->pedidoCompra  = $albaran->getPedidoCompra();
            }
            if (!$albaran->getAlbaranLineas()->isEmpty()) {
                $this->albaranLinea = $albaran->getAlbaranLineas();
            } else {
                $this->albaranLinea = new ArrayCollection();
            }
        }
    }

    /**
     * @return Albaran
     */
    public function getEntityData()
    {
        $albaran = new Albaran();
/*        $albaran->setCreated($this->getCreated());
        $albaran->setCreatedby($this->getCreatedby());
        $albaran->setDeleted($this->getDeleted());
        $albaran->setDeletedby($this->getDeletedby());
        $albaran->setUpdated($this->getUpdated());
        $albaran->setUpdatedby($this->getUpdatedby());*/

        $albaran->setConsecutivoCompra($this->getConsecutivoCompra());
        $albaran->setNumeroReferencia($this->getNumeroReferencia());
        $albaran->setFechaMovimiento($this->getFechaMovimiento());
        $albaran->setFechaContable($this->getFechaContable());
        $albaran->setEstadoDocumento($this->getEstadoDocumento());

        if ($this->getTercero() !== null) {
            $albaran->setTercero($this->getTercero());
        }
        if ($this->getAlmacen() !== null) {
            $albaran->setAlmacen($this->getAlmacen());
        }
        if ($this->getPedidoCompra() !== null) {
            $albaran->setPedidoCompra($this->getPedidoCompra());
        }
        if (!$this->getAlbaranLinea()->isEmpty()) {
            foreach ($this->getAlbaranLinea() as $lineas) {
                $albaran->addAlbaranLinea($lineas);
            }
        }

        return $albaran;
    }

    /**
     * @return ArrayCollection
     */
    public function getAlbaranLinea()
    {
        return $this->albaranLinea;
    }

    /**
     * @param ArrayCollection $albaranLinea
     */
    public function setAlbaranLinea($albaranLinea)
    {
        $this->albaranLinea = $albaranLinea;
    }

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
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * @param \HatueySoft\SecurityBundle\Entity\User $createdby
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;
    }

    /**
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getDeletedby()
    {
        return $this->deletedby;
    }

    /**
     * @param \HatueySoft\SecurityBundle\Entity\User $deletedby
     */
    public function setDeletedby($deletedby)
    {
        $this->deletedby = $deletedby;
    }

    /**
     * @return string
     */
    public function getEstadoDocumento()
    {
        return $this->estadoDocumento;
    }

    /**
     * @param string $estadoDocumento
     */
    public function setEstadoDocumento($estadoDocumento)
    {
        $this->estadoDocumento = $estadoDocumento;
    }

    /**
     * @return date
     */
    public function getFechaContable()
    {
        return $this->fechaContable;
    }

    /**
     * @param date $fechaContable
     */
    public function setFechaContable($fechaContable)
    {
        $this->fechaContable = $fechaContable;
    }

    /**
     * @return date
     */
    public function getFechaMovimiento()
    {
        return $this->fechaMovimiento;
    }

    /**
     * @param date $fechaMovimiento
     */
    public function setFechaMovimiento($fechaMovimiento)
    {
        $this->fechaMovimiento = $fechaMovimiento;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return \Buseta\BodegaBundle\Entity\PedidoCompra
     */
    public function getPedidoCompra()
    {
        return $this->pedidoCompra;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     */
    public function setPedidoCompra($pedidoCompra)
    {
        $this->pedidoCompra = $pedidoCompra;
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
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \HatueySoft\SecurityBundle\Entity\User
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * @param \HatueySoft\SecurityBundle\Entity\User $updatedby
     */
    public function setUpdatedby($updatedby)
    {
        $this->updatedby = $updatedby;
    }


}
