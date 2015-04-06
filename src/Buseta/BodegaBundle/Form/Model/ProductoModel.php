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
     *
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $codigo;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var \Buseta\NomencladorBundle\Entity\UOM
     * @Assert\NotBlank()
     */
    private $uom;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Condicion
     * @Assert\NotBlank()
     */
    private $condicion;

    /**
     * @var \Buseta\BodegaBundle\Entity\CategoriaProducto
     * @Assert\NotBlank()
     */
    private $categoriaProducto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $movimientos;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $pedido_compra_lineas;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $albaranLinea;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     * @Assert\NotBlank()
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     * @Assert\NotBlank()
     */
    private $subgrupo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $precioProducto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $costoProducto;

    /**
     * Constructor
     */
    public function __construct(Producto $producto = null)
    {
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pedido_compra_lineas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->albaranLinea = new \Doctrine\Common\Collections\ArrayCollection();
        $this->precioProducto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->costoProducto = new \Doctrine\Common\Collections\ArrayCollection();

        if ($producto !== null) {
            $this->id = $producto->getId();
            $this->codigo = $producto->getCodigo();
            $this->nombre = $producto->getNombre();
            $this->activo = $producto->getActivo();

            if ($producto->getUom()) {
                $this->uom  = $producto->getUom();
            }
            if ($producto->getCondicion()) {
                $this->condicion  = $producto->getCondicion();
            }
            if ($producto->getMovimientos()) {
                $this->movimientos  = $producto->getMovimientos();
            }
            if ($producto->getAlbaranLinea()) {
                $this->albaranLinea  = $producto->getAlbaranLinea();
            }
            if ($producto->getGrupo()) {
                $this->grupos  = $producto->getGrupo();
            }
            if ($producto->getSubgrupo()) {
                $this->subgrupos  = $producto->getSubgrupo();
            }
            if ($producto->getPrecioProducto()) {
                $this->precioProducto  = $producto->getPrecioProducto();
            }
            if ($producto->getCostoProducto()) {
                $this->costoProducto  = $producto->getCostoProducto();
            }
            if ($producto->getCategoriaProducto()) {
                $this->categoriaProducto  = $producto->getCategoriaProducto();
            }

            if (!$producto->getPedidoCompraLineas()->isEmpty()) {
                $this->pedido_compra_lineas = $producto->getPedidoCompraLineas();
            } else {
                $this->pedido_compra_lineas = new ArrayCollection();
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
        $producto->setNombre($this->getNombre());
        $producto->setActivo($this->getActivo());
        $producto->setCategoriaProducto($this->getCategoriaProducto());

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

        if (!$this->getMovimientos()->isEmpty()) {
            foreach ($this->getMovimientos() as $movimientos) {
                $producto->addMovimiento($movimientos);
            }
        }
        if (!$this->getPedidoCompraLineas()->isEmpty()) {
            foreach ($this->getPedidoCompraLineas() as $pedidos) {
                $producto->addPedidoCompraLinea($pedidos);
            }
        }
        if (!$this->getAlbaranLinea()->isEmpty()) {
            foreach ($this->getAlbaranLinea() as $albaranes) {
                $producto->addAlbaranLinea($albaranes);
            }
        }
        if (!$this->getPrecioProducto()->isEmpty()) {
            foreach ($this->getPrecioProducto() as $precios) {
                $producto->addPrecioProducto($precios);
            }
        }
        if (!$this->getCostoProducto()->isEmpty()) {
            foreach ($this->getCostoProducto() as $costos) {
                $producto->addCostoProducto($costos);
            }
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
     * @return ArrayCollection
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    /**
     * @param ArrayCollection $movimientos
     */
    public function setMovimientos($movimientos)
    {
        $this->movimientos = $movimientos;
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
    public function getPedidoCompraLineas()
    {
        return $this->pedido_compra_lineas;
    }

    /**
     * @param ArrayCollection $pedido_compra_lineas
     */
    public function setPedidoCompraLineas($pedido_compra_lineas)
    {
        $this->pedido_compra_lineas = $pedido_compra_lineas;
    }

    /**
     * @return ArrayCollection
     */
    public function getPrecioProducto()
    {
        return $this->precioProducto;
    }

    /**
     * @param ArrayCollection $precioProducto
     */
    public function setPrecioProducto($precioProducto)
    {
        $this->precioProducto = $precioProducto;
    }

    /**
     * @return ArrayCollection
     */
    public function getCostoProducto()
    {
        return $this->costoProducto;
    }

    /**
     * @param ArrayCollection $costoProducto
     */
    public function setCostoProducto($costoProducto)
    {
        $this->costoProducto = $costoProducto;
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




}
