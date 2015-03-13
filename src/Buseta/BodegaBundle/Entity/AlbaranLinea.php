<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AlbaranLinea.
 *
 * @ORM\Table(name="d_albaran_linea")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\AlbaranLineaRepository")
 */
class AlbaranLinea
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
     * @ORM\Column(name="linea", type="string", nullable=false)
     */
    private $linea;

    /**
     * @var string
     *
     * @ORM\Column(name="valorAtributos", type="string", nullable=true)
     */
    private $valorAtributos;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="albaranLinea")
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega", inversedBy="albaranLinea")
     */
    private $almacen;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\UOM")
     */
    private $uom;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadMovida", type="integer")
     * @Assert\Type("integer")
     */
    private $cantidadMovida;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Albaran", inversedBy="albaranLinea")
     */
    private $albaran;

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
     * Set linea.
     *
     * @param string $linea
     *
     * @return AlbaranLinea
     */
    public function setLinea($linea)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea.
     *
     * @return string
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set valorAtributos.
     *
     * @param string $valorAtributos
     *
     * @return AlbaranLinea
     */
    public function setValorAtributos($valorAtributos)
    {
        $this->valorAtributos = $valorAtributos;

        return $this;
    }

    /**
     * Get valorAtributos.
     *
     * @return string
     */
    public function getValorAtributos()
    {
        return $this->valorAtributos;
    }

    /**
     * Set cantidadMovida.
     *
     * @param integer $cantidadMovida
     *
     * @return AlbaranLinea
     */
    public function setCantidadMovida($cantidadMovida)
    {
        $this->cantidadMovida = $cantidadMovida;

        return $this;
    }

    /**
     * Get cantidadMovida.
     *
     * @return integer
     */
    public function getCantidadMovida()
    {
        return $this->cantidadMovida;
    }

    /**
     * Set producto.
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     *
     * @return AlbaranLinea
     */
    public function setProducto(\Buseta\BodegaBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto.
     *
     * @return \Buseta\BodegaBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set almacen.
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     *
     * @return AlbaranLinea
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
     * Set uom.
     *
     * @param \Buseta\NomencladorBundle\Entity\UOM $uom
     *
     * @return AlbaranLinea
     */
    public function setUom(\Buseta\NomencladorBundle\Entity\UOM $uom = null)
    {
        $this->uom = $uom;

        return $this;
    }

    /**
     * Get uom.
     *
     * @return \Buseta\NomencladorBundle\Entity\UOM
     */
    public function getUom()
    {
        return $this->uom;
    }

    /**
     * Set albaran.
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     *
     * @return AlbaranLinea
     */
    public function setAlbaran(\Buseta\BodegaBundle\Entity\Albaran $albaran = null)
    {
        $this->albaran = $albaran;

        return $this;
    }

    /**
     * Get albaran.
     *
     * @return \Buseta\BodegaBundle\Entity\Albaran
     */
    public function getAlbaran()
    {
        return $this->albaran;
    }
}
