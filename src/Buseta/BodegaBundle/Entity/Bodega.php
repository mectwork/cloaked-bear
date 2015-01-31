<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bodega
 *
 * @ORM\Table(name="d_bodega")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\BodegaRepository")
 */
class Bodega
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
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Producto", mappedBy="bodega", cascade={"all"})
     */
    private $productos;

//    /**
//     * @var \Doctrine\Common\Collections\ArrayCollection
//     *
//     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Movimiento", mappedBy="movidoA", cascade={"all"})
//     */
//    private $movimientos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\Linea", mappedBy="bodegas", cascade={"all"})
     */
    private $lineas;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompra", mappedBy="almacen", cascade={"all"})
     */
    private $pedidoCompra;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\AlbaranLinea", mappedBy="almacen", cascade={"all"})
     */
    private $albaranLinea;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Albaran", mappedBy="almacen", cascade={"all"})
     */
    private $albaran;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lineas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lineas
     *
     * @param \Buseta\TallerBundle\Entity\Linea $lineas
     * @return Bodega
     */
    public function addLinea(\Buseta\TallerBundle\Entity\Linea $lineas)
    {
        $this->lineas[] = $lineas;

        return $this;
    }

    /**
     * Remove lineas
     *
     * @param \Buseta\TallerBundle\Entity\Linea $lineas
     */
    public function removeLinea(\Buseta\TallerBundle\Entity\Linea $lineas)
    {
        $this->lineas->removeElement($lineas);
    }

    /**
     * Get lineas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineas()
    {
        return $this->lineas;
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
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
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
     * Add productos
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $productos
     * @return Bodega
     */
    public function addProducto(\Buseta\BodegaBundle\Entity\Producto $productos)
    {
        $productos->setBodega($this);

        $this->productos[] = $productos;
    
        return $this;
    }

    /**
     * Remove productos
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $productos
     */
    public function removeProducto(\Buseta\BodegaBundle\Entity\Producto $productos)
    {
        $this->productos->removeElement($productos);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }

    public function __toString()
    {
        return $this->getNombre();
    }


//    /**
//     * Add movimientos
//     *
//     * @param \Buseta\BodegaBundle\Entity\Movimiento $movimientos
//     * @return Bodega
//     */
//    public function addMovimiento(\Buseta\BodegaBundle\Entity\Movimiento $movimientos)
//    {
//        $this->movimientos[] = $movimientos;
//
//        return $this;
//    }
//
//    /**
//     * Remove movimientos
//     *
//     * @param \Buseta\BodegaBundle\Entity\Movimiento $movimientos
//     */
//    public function removeMovimiento(\Buseta\BodegaBundle\Entity\Movimiento $movimientos)
//    {
//        $this->movimientos->removeElement($movimientos);
//    }
//
//    /**
//     * Get movimientos
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getMovimientos()
//    {
//        return $this->movimientos;
//    }

    /**
     * Add pedidoCompra
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     * @return Bodega
     */
    public function addPedidoCompra(\Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra)
    {
        $this->pedidoCompra[] = $pedidoCompra;
    
        return $this;
    }

    /**
     * Remove pedidoCompra
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     */
    public function removePedidoCompra(\Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra)
    {
        $this->pedidoCompra->removeElement($pedidoCompra);
    }

    /**
     * Get pedidoCompra
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPedidoCompra()
    {
        return $this->pedidoCompra;
    }

    /**
     * Add albaran
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     * @return Bodega
     */
    public function addAlbaran(\Buseta\BodegaBundle\Entity\Albaran $albaran)
    {
        $this->albaran[] = $albaran;
    
        return $this;
    }

    /**
     * Remove albaran
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     */
    public function removeAlbaran(\Buseta\BodegaBundle\Entity\Albaran $albaran)
    {
        $this->albaran->removeElement($albaran);
    }

    /**
     * Get albaran
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlbaran()
    {
        return $this->albaran;
    }

    /**
     * Add albaranLinea
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     * @return Bodega
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
}