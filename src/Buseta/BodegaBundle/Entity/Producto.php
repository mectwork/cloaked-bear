<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\ProductoModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Producto.
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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string")
     * @Assert\NotBlank()
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Condicion")
     */
    private $condicion;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\CategoriaProducto", inversedBy="productos")
     */
    private $categoriaProducto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Movimiento", mappedBy="producto", cascade={"all"})
     */
    private $movimientos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\InventarioFisicoLinea", mappedBy="producto", cascade={"all"})
     */
    private $inventario_fisico_lineas;

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
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\NecesidadMaterialLinea", mappedBy="producto", cascade={"all"})
     */
    private $necesidad_material_lineas;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\AlbaranLinea", mappedBy="producto", cascade={"all"})
     */
    private $albaranLinea;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo")
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PrecioProducto", mappedBy="producto", cascade={"all"})
     */
    private $precioProducto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\CostoProducto", mappedBy="producto", cascade={"all"})
     */
    private $costoProducto;

    /**
     * @param ProductoModel $model
     * @return Producto
     */
    public function setModelData(ProductoModel $model)
    {
        $this->id = $model->getId();
        $this->codigo = $model->getCodigo();
        $this->nombre = $model->getNombre();
        $this->descripcion = $model->getDescripcion();
        $this->activo = $model->getActivo();

        if ($model->getUom()) {
            $this->uom  = $model->getUom();
        }
        if ($model->getCondicion()) {
            $this->condicion  = $model->getCondicion();
        }
        if ($model->getMovimientos()) {
            $this->movimientos  = $model->getMovimientos();
        }
        if ($model->getAlbaranLinea()) {
            $this->albaranLinea  = $model->getAlbaranLinea();
        }
        if ($model->getGrupo()) {
            $this->grupo  = $model->getGrupo();
        }
        if ($model->getSubgrupo()) {
            $this->subgrupo  = $model->getSubgrupo();
        }
        if ($model->getPrecioProducto()) {
            $this->precioProducto  = $model->getPrecioProducto();
        }
        if ($model->getCostoProducto()) {
            $this->costoProducto  = $model->getCostoProducto();
        }
        if ($model->getCategoriaProducto()) {
            $this->categoriaProducto  = $model->getCategoriaProducto();
        }
        if (!$model->getPedidoCompraLineas()->isEmpty()) {
            $this->pedido_compra_lineas = $model->getPedidoCompraLineas();
        } else {
            $this->pedido_compra_lineas = new ArrayCollection();
        }

        return $this;
    }

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
     * Constructor.
     */
    public function __construct()
    {
        $this->pedido_compra_lineas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add movimientos.
     *
     * @param \Buseta\BodegaBundle\Entity\Movimiento $movimientos
     *
     * @return Producto
     */
    public function addMovimiento(\Buseta\BodegaBundle\Entity\Movimiento $movimientos)
    {
        $movimientos->setProducto($this);

        $this->movimientos[] = $movimientos;

        return $this;
    }

    /**
     * Remove movimientos.
     *
     * @param \Buseta\BodegaBundle\Entity\Movimiento $movimientos
     */
    public function removeMovimiento(\Buseta\BodegaBundle\Entity\Movimiento $movimientos)
    {
        $this->movimientos->removeElement($movimientos);
    }

    /**
     * Get movimientos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    /**
     * Set grupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     *
     * @return Producto
     */
    public function setGrupo(\Buseta\NomencladorBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo.
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set subgrupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo
     *
     * @return Producto
     */
    public function setSubgrupo(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo = null)
    {
        $this->subgrupo = $subgrupo;

        return $this;
    }

    /**
     * Get subgrupos.
     *
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * Add pedido_compra_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     *
     * @return Producto
     */
    public function addPedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $this->pedido_compra_lineas[] = $pedidoCompraLineas;

        return $this;
    }

    /**
     * Remove pedido_compra_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     */
    public function removePedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $this->pedido_compra_lineas->removeElement($pedidoCompraLineas);
    }

    /**
     * Get pedido_compra_lineas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidoCompraLineas()
    {
        return $this->pedido_compra_lineas;
    }

    /**
     * Add necesidad_material_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas
     *
     * @return Producto
     */
    public function addNecesidadMaterialLinea(\Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas)
    {
        $this->necesidad_material_lineas[] = $necesidadMaterialLineas;

        return $this;
    }

    /**
     * Remove necesidad_material_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas
     */
    public function removeNecesidadMaterialLinea(\Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas)
    {
        $this->pedido_compra_lineas->removeElement($necesidadMaterialLineas);
    }

    /**
     * Get necesidad_material_lineas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNecesidadMaterialLineas()
    {
        return $this->necesidad_material_lineas;
    }

    /**
     * Add albaranLinea.
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     *
     * @return Producto
     */
    public function addAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
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
     * Add precioProducto.
     *
     * @param \Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto
     *
     * @return Producto
     */
    public function addPrecioProducto(\Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto)
    {
        $precioProducto->setProducto($this);

        $this->precioProducto[] = $precioProducto;

        return $this;
    }

    /**
     * Remove precioProducto.
     *
     * @param \Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto
     */
    public function removePrecioProducto(\Buseta\BodegaBundle\Entity\PrecioProducto $precioProducto)
    {
        $this->precioProducto->removeElement($precioProducto);
    }

    /**
     * Get precioProducto.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrecioProducto()
    {
        return $this->precioProducto;
    }

    /**
     * Add costoProducto.
     *
     * @param \Buseta\BodegaBundle\Entity\CostoProducto $costoProducto
     *
     * @return Producto
     */
    public function addCostoProducto(\Buseta\BodegaBundle\Entity\CostoProducto $costoProducto)
    {
        $costoProducto->setProducto($this);

        $this->costoProducto[] = $costoProducto;

        return $this;
    }

    /**
     * Remove costoProducto.
     *
     * @param \Buseta\BodegaBundle\Entity\CostoProducto $costoProducto
     */
    public function removeCostoProducto(\Buseta\BodegaBundle\Entity\CostoProducto $costoProducto)
    {
        $this->costoProducto->removeElement($costoProducto);
    }

    /**
     * Get costoProducto.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCostoProducto()
    {
        return $this->costoProducto;
    }

    /**
     * Set categoriaProducto.
     *
     * @param \Buseta\BodegaBundle\Entity\CategoriaProducto $categoriaProducto
     *
     * @return Producto
     */
    public function setCategoriaProducto(\Buseta\BodegaBundle\Entity\CategoriaProducto $categoriaProducto = null)
    {
        $this->categoriaProducto = $categoriaProducto;

        return $this;
    }

    /**
     * Get categoriaProducto.
     *
     * @return \Buseta\BodegaBundle\Entity\CategoriaProducto
     */
    public function getCategoriaProducto()
    {
        return $this->categoriaProducto;
    }

    /**
     * Add inventario_fisico_lineas
     *
     * @param \Buseta\BodegaBundle\Entity\InventarioFisicoLinea $inventarioFisicoLineas
     * @return Producto
     */
    public function addInventarioFisicoLinea(\Buseta\BodegaBundle\Entity\InventarioFisicoLinea $inventarioFisicoLineas)
    {
        $inventarioFisicoLineas->setProducto($this);

        $this->inventario_fisico_lineas[] = $inventarioFisicoLineas;
    
        return $this;
    }

    /**
     * Remove inventario_fisico_lineas
     *
     * @param \Buseta\BodegaBundle\Entity\InventarioFisicoLinea $inventarioFisicoLineas
     */
    public function removeInventarioFisicoLinea(\Buseta\BodegaBundle\Entity\InventarioFisicoLinea $inventarioFisicoLineas)
    {
        $this->inventario_fisico_lineas->removeElement($inventarioFisicoLineas);
    }

    /**
     * Get inventario_fisico_lineas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventarioFisicoLineas()
    {
        return $this->inventario_fisico_lineas;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Producto
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}