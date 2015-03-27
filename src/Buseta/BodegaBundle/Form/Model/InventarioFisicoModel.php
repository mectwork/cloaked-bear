<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\InventarioFisico;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * InventarioFisico Model
 *
 */
class InventarioFisicoModel
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
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     * @Assert\NotBlank()
     */
    private $almacen;

    /**
     * @var date
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fecha;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $estado = 'BO';

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $inventarioFisicoLinea;

    /**
     * Constructor
     */
    public function __construct(InventarioFisico $inventarioFisico = null)
    {
        $this->inventarioFisicoLinea = new \Doctrine\Common\Collections\ArrayCollection();

        if ($inventarioFisico !== null) {
            $this->id = $inventarioFisico->getId();
            $this->nombre = $inventarioFisico->getNombre();
            $this->descripcion = $inventarioFisico->getDescripcion();
            $this->fecha = $inventarioFisico->getFecha();
            $this->estado = $inventarioFisico->getEstado();

            if ($inventarioFisico->getAlmacen()) {
                $this->almacen  = $inventarioFisico->getAlmacen();
            }
            if (!$inventarioFisico->getInventarioFisicoLineas()->isEmpty()) {
                $this->inventarioFisicoLinea = $inventarioFisico->getInventarioFisicoLineas();
            } else {
                $this->inventarioFisicoLinea = new ArrayCollection();
            }
        }
    }

    /**
     * @return InventarioFisico
     */
    public function getEntityData()
    {
        $inventarioFisico = new InventarioFisico();
        $inventarioFisico->setNombre($this->getNombre());
        $inventarioFisico->setDescripcion($this->getDescripcion());
        $inventarioFisico->setFecha($this->getFecha());
        $inventarioFisico->setEstado($this->getEstado());

        if ($this->getAlmacen() !== null) {
            $inventarioFisico->setAlmacen($this->getAlmacen());
        }
        if (!$this->getInventarioFisicoLinea()->isEmpty()) {
            foreach ($this->getInventarioFisicoLinea() as $lineas) {
                $inventarioFisico->addInventarioFisicoLinea($lineas);
            }
        }

        return $inventarioFisico;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getAlmacen()
    {
        return $this->almacen;
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
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return date
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param date $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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
     * @return ArrayCollection
     */
    public function getInventarioFisicoLinea()
    {
        return $this->inventarioFisicoLinea;
    }

    /**
     * @param ArrayCollection $inventarioFisicoLinea
     */
    public function setInventarioFisicoLinea($inventarioFisicoLinea)
    {
        $this->inventarioFisicoLinea = $inventarioFisicoLinea;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }


}
