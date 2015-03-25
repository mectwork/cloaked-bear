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
     * @var \Buseta\BodegaBundle\Entity\Bodega
     * @Assert\NotBlank()
     */
    private $bodega;

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
     * @var integer
     * @Assert\NotBlank()
     */
    private $minimo_bodega;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $maximo_bodega;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $grupos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $subgrupos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @Assert\NotBlank()
     */
    private $precioProducto;

    /**
     * Constructor
     */
    public function __construct(Producto $producto = null)
    {
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pedido_compra_lineas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->albaranLinea = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subgrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->precioProducto = new \Doctrine\Common\Collections\ArrayCollection();

        if ($producto !== null) {
            $this->id = $producto->getId();
            $this->codigo = $producto->getCodigo();
            $this->nombre = $producto->getNombre();
            $this->activo = $producto->getActivo();
            $this->minimo_bodega = $producto->getMinimoBodega();
            $this->maximo_bodega = $producto->getMaximoBodega();

            if ($producto->getUom()) {
                $this->uom  = $producto->getUom();
            }
            if ($producto->getCondicion()) {
                $this->condicion  = $producto->getCondicion();
            }
            if ($producto->getBodega()) {
                $this->bodega  = $producto->getBodega();
            }

            if (!$producto->getMovimientos()->isEmpty()) {
                $this->movimientos = $producto->getMovimientos();
            } else {
                $this->movimientos = new ArrayCollection();
            }
            if (!$producto->getPedidoCompraLineas()->isEmpty()) {
                $this->pedido_compra_lineas = $producto->getPedidoCompraLineas();
            } else {
                $this->pedido_compra_lineas = new ArrayCollection();
            }
            if (!$producto->getAlbaranLinea()->isEmpty()) {
                $this->albaranLinea = $producto->getAlbaranLinea();
            } else {
                $this->albaranLinea = new ArrayCollection();
            }
            if (!$producto->getGrupos()->isEmpty()) {
                $this->grupos = $producto->getGrupos();
            } else {
                $this->grupos = new ArrayCollection();
            }
            if (!$producto->getSubgrupos()->isEmpty()) {
                $this->subgrupos = $producto->getSubgrupos();
            } else {
                $this->subgrupos = new ArrayCollection();
            }
            if (!$producto->getPrecioProducto()->isEmpty()) {
                $this->precioProducto = $producto->getPrecioProducto();
            } else {
                $this->precioProducto = new ArrayCollection();
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
        $producto->setMinimoBodega($this->getMinimoBodega());
        $producto->setMaximoBodega($this->getMaximoBodega());

        if ($this->getUom() !== null) {
            $producto->setUom($this->getUom());
        }
        if ($this->getCondicion() !== null) {
            $producto->setCondicion($this->getCondicion());
        }
        if ($this->getBodega() !== null) {
            $producto->setBodega($this->getBodega());
        }
        if ($this->getGrupos() !== null) {
            $producto->setGrupos($this->getGrupos());
        }
        if ($this->getSubgrupos() !== null) {
            $producto->setSubgrupos($this->getSubgrupos());
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
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getBodega()
    {
        return $this->bodega;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Bodega $bodega
     */
    public function setBodega($bodega)
    {
        $this->bodega = $bodega;
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
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * @param ArrayCollection $grupos
     */
    public function setGrupos($grupos)
    {
        $this->grupos = $grupos;
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
     * @return int
     */
    public function getMaximoBodega()
    {
        return $this->maximo_bodega;
    }

    /**
     * @param int $maximo_bodega
     */
    public function setMaximoBodega($maximo_bodega)
    {
        $this->maximo_bodega = $maximo_bodega;
    }

    /**
     * @return int
     */
    public function getMinimoBodega()
    {
        return $this->minimo_bodega;
    }

    /**
     * @param int $minimo_bodega
     */
    public function setMinimoBodega($minimo_bodega)
    {
        $this->minimo_bodega = $minimo_bodega;
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
    public function getSubgrupos()
    {
        return $this->subgrupos;
    }

    /**
     * @param ArrayCollection $subgrupos
     */
    public function setSubgrupos($subgrupos)
    {
        $this->subgrupos = $subgrupos;
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
