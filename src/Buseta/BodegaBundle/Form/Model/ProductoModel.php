<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Producto;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Producto Model
 *
 */
class ProductoModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $codigo;

    /**
     * @var string
     */
    private $codigoA;

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
     * @var \Buseta\NomencladorBundle\Entity\UOM
     * @Assert\NotBlank()
     */
    private $uom;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Condicion
     */
    private $condicion;

    /**
     * @var \Buseta\BodegaBundle\Entity\CategoriaProducto
     */
    private $categoriaProducto;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     * @Assert\NotNull()
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     * @Assert\NotNull()
     */
    private $subgrupo;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     */
    private $proveedor;

    /**
     * Constructor
     */
    public function __construct(Producto $producto = null)
    {
        if ($producto !== null) {
            $this->id = $producto->getId();
            $this->codigo = $producto->getCodigo();
            $this->codigoA = $producto->getCodigoA();
            $this->nombre = $producto->getNombre();
            $this->descripcion = $producto->getDescripcion();
            $this->activo = $producto->getActivo();
            $this->proveedor = $producto->getProveedor();

            if ($producto->getUom()) {
                $this->uom  = $producto->getUom();
            }
            if ($producto->getCondicion()) {
                $this->condicion  = $producto->getCondicion();
            }
            if ($producto->getGrupo()) {
                $this->grupo  = $producto->getGrupo();
            }
            if ($producto->getSubgrupo()) {
                $this->subgrupo  = $producto->getSubgrupo();
            }
            if ($producto->getCategoriaProducto()) {
                $this->categoriaProducto  = $producto->getCategoriaProducto();
            }
        }
    }

    /**
     * @return Producto
     */
    public function getEntityData()
    {
        $producto = new Producto();
        $producto->setCodigo($this->getCodigo());
        $producto->setCodigoA($this->getCodigoA());
        $producto->setNombre($this->getNombre());
        $producto->setDescripcion($this->getDescripcion());
        $producto->setActivo($this->getActivo());
        $producto->setCategoriaProducto($this->getCategoriaProducto());
        $producto->setProveedor($this->getProveedor());

        if ($this->getUom() !== null) {
            $producto->setUom($this->getUom());
        }
        if ($this->getCondicion() !== null) {
            $producto->setCondicion($this->getCondicion());
        }
        if ($this->getGrupo() !== null) {
            $producto->setGrupo($this->getGrupo());
        }
        if ($this->getSubgrupo() !== null) {
            $producto->setSubgrupo($this->getSubgrupo());
        }

        return $producto;
    }

    /**
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\CategoriaProducto
     */
    public function getCategoriaProducto()
    {
        return $this->categoriaProducto;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\CategoriaProducto $categoriaProducto
     */
    public function setCategoriaProducto($categoriaProducto)
    {
        $this->categoriaProducto = $categoriaProducto;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getCodigoA()
    {
        return $this->codigoA;
    }

    /**
     * @param string $codigoA
     */
    public function setCodigoA($codigoA)
    {
        $this->codigoA = $codigoA;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Condicion
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Condicion $condicion
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;
    }

    /**
     * @return ArrayCollection
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param ArrayCollection $grupos
     */
    public function setGrupo($grupos)
    {
        $this->grupo = $grupos;
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

    /**
     * @return ArrayCollection
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * @param ArrayCollection $subgrupos
     */
    public function setSubgrupo($subgrupos)
    {
        $this->subgrupo = $subgrupos;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\UOM
     */
    public function getUom()
    {
        return $this->uom;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\UOM $uom
     */
    public function setUom($uom)
    {
        $this->uom = $uom;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Tercero $proveedor
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }
}
