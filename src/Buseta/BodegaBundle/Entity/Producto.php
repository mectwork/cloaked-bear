<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Producto
 *
 * @ORM\Table(name="d_producto")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\ProductoRepository")
 */
class Producto
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
     * @ORM\Column(name="codigo", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\UOM")
     */
    private $uom;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Condicion", inversedBy="productos")
     */
    private $condicion;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega", inversedBy="productos")
     */
    private $bodega;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\CategoriaProducto")
     */
    private $categoriaProducto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Movimiento", mappedBy="producto", cascade={"all"})
     */
    private $movimientos;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompraLinea", mappedBy="producto", cascade={"all"})
     */
    private $pedido_compra_lineas;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\AlbaranLinea", mappedBy="producto", cascade={"all"})
     */
    private $albaranLinea;

    /**
     * @var integer
     *
     * @ORM\Column(name="minimo_bodega", type="integer")
     * @Assert\NotBlank()
     */
    private $minimo_bodega;

    /**
     * @var integer
     *
     * @ORM\Column(name="maximo_bodega", type="integer")
     * @Assert\NotBlank()
     */
    private $maximo_bodega;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo")
     */
    private $grupos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PrecioProducto", mappedBy="producto", cascade={"all"})
     */
    private $precioProducto;

    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param mixed $condicion
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;
    }

    /**
     * @return mixed
     */
    public function getCondicion()
    {
        return $this->condicion;
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
    public function getCodigo()
    {
        return $this->codigo;
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $uom
     */
    public function setUom($uom)
    {
        $this->uom = $uom;
    }

    /**
     * @return mixed
     */
    public function getUom()
    {
        return $this->uom;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pedido_compra_lineas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set bodega
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $bodega
     * @return Producto
     */
    public function setBodega(\Buseta\BodegaBundle\Entity\Bodega $bodega = null)
    {
        $this->bodega = $bodega;
    
        return $this;
    }

    /**
     * Get bodega
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega 
     */
    public function getBodega()
    {
        return $this->bodega;
    }

    /**
     * Add movimientos
     *
     * @param \Buseta\BodegaBundle\Entity\Movimiento $movimientos
     * @return Producto
     */
    public function addMovimiento(\Buseta\BodegaBundle\Entity\Movimiento $movimientos)
    {
        $movimientos->setProducto($this);

        $this->movimientos[] = $movimientos;

        return $this;
    }

    /**
     * Remove movimientos
     *
     * @param \Buseta\BodegaBundle\Entity\Movimiento $movimientos
     */
    public function removeMovimiento(\Buseta\BodegaBundle\Entity\Movimiento $movimientos)
    {
        $this->movimientos->removeElement($movimientos);
    }

    /**
     * Get movimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    /**
     * Set minimo_bodega
     *
     * @param integer $minimoBodega
     * @return Producto
     */
    public function setMinimoBodega($minimoBodega)
    {
        $this->minimo_bodega = $minimoBodega;
    
        return $this;
    }

    /**
     * Get minimo_bodega
     *
     * @return integer 
     */
    public function getMinimoBodega()
    {
        return $this->minimo_bodega;
    }

    /**
     * Set maximo_bodega
     *
     * @param integer $maximoBodega
     * @return Producto
     */
    public function setMaximoBodega($maximoBodega)
    {
        $this->maximo_bodega = $maximoBodega;
    
        return $this;
    }

    /**
     * Get maximo_bodega
     *
     * @return integer 
     */
    public function getMaximoBodega()
    {
        return $this->maximo_bodega;
    }

    /**
     * Set grupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupos
     * @return Producto
     */
    public function setGrupos(\Buseta\NomencladorBundle\Entity\Grupo $grupos = null)
    {
        $this->grupos = $grupos;
    
        return $this;
    }

    /**
     * Get grupos
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Set subgrupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos
     * @return Producto
     */
    public function setSubgrupos(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos = null)
    {
        $this->subgrupos = $subgrupos;
    
        return $this;
    }

    /**
     * Get subgrupos
     *
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo 
     */
    public function getSubgrupos()
    {
        return $this->subgrupos;
    }

    /**
     * Add pedido_compra_lineas
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     * @return Producto
     */
    public function addPedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $this->pedido_compra_lineas[] = $pedidoCompraLineas;
    
        return $this;
    }

    /**
     * Remove pedido_compra_lineas
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     */
    public function removePedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $this->pedido_compra_lineas->removeElement($pedidoCompraLineas);
    }

    /**
     * Get pedido_compra_lineas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPedidoCompraLineas()
    {
        return $this->pedido_compra_lineas;
    }

    /**
     * Add albaranLinea
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     * @return Producto
     */
    public function addAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $this->albaranLinea[] = $albaranLinea;
    
        return $this;
    }

    /**
     * Remove albaranLinea
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     */
    public function removeAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $this->albaranLinea->removeElement($albaranLinea);
    }

    /**
     * Get albaranLinea
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlbaranLinea()
    {
        return $this->albaranLinea;
    }

    /**
     * Add precioProducto
     *
     * @param \Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto
     * @return Producto
     */
    public function addPrecioProducto(\Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto)
    {
        $precioProducto->setProducto($this);

        $this->precioProducto[] = $precioProducto;
    
        return $this;
    }

    /**
     * Remove precioProducto
     *
     * @param \Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto
     */
    public function removePrecioProducto(\Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto)
    {
        $this->precioProducto->removeElement($precioProducto);
    }

    /**
     * Get precioProducto
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrecioProducto()
    {
        return $this->precioProducto;
    }

    /**
     * Set categoriaProducto
     *
     * @param \Buseta\BodegaBundle\Entity\CategoriaProducto $categoriaProducto
     * @return Producto
     */
    public function setCategoriaProducto(\Buseta\BodegaBundle\Entity\CategoriaProducto $categoriaProducto = null)
    {
        $this->categoriaProducto = $categoriaProducto;
    
        return $this;
    }

    /**
     * Get categoriaProducto
     *
     * @return \Buseta\BodegaBundle\Entity\CategoriaProducto 
     */
    public function getCategoriaProducto()
    {
        return $this->categoriaProducto;
    }
}