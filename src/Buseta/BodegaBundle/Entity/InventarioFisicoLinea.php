<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Interfaces\GeneradorBitacoraInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InventarioFisicoLinea.
 *
 * @ORM\Table(name="d_inventario_fisico_linea")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\InventarioFisicoLineaRepository")
 */
class InventarioFisicoLinea implements GeneradorBitacoraInterface
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
     * @ORM\Column(name="numero", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="inventario_fisico_lineas")
     * @Assert\NotBlank()
     */
    private $producto;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadReal", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $cantidadReal;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadTeorica", type="integer")
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $cantidadTeorica;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\InventarioFisico", inversedBy="inventarioFisicoLineas")
     */
    private $inventarioFisico;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return InventarioFisicoLinea
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return InventarioFisicoLinea
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

    /**
     * Set cantidadReal
     *
     * @param integer $cantidadReal
     * @return InventarioFisicoLinea
     */
    public function setCantidadReal($cantidadReal)
    {
        $this->cantidadReal = $cantidadReal;

        return $this;
    }

    /**
     * Get cantidadReal
     *
     * @return integer
     */
    public function getCantidadReal()
    {
        return $this->cantidadReal;
    }

    /**
     * Set cantidadTeorica
     *
     * @param integer $cantidadTeorica
     * @return InventarioFisicoLinea
     */
    public function setCantidadTeorica($cantidadTeorica)
    {
        $this->cantidadTeorica = $cantidadTeorica;

        return $this;
    }

    /**
     * Get cantidadTeorica
     *
     * @return integer
     */
    public function getCantidadTeorica()
    {
        return $this->cantidadTeorica;
    }

    /**
     * Set producto
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     * @return InventarioFisicoLinea
     */
    public function setProducto(\Buseta\BodegaBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \Buseta\BodegaBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Set inventarioFisico
     *
     * @param \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico
     * @return InventarioFisicoLinea
     */
    public function setInventarioFisico(\Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico = null)
    {
        $this->inventarioFisico = $inventarioFisico;

        return $this;
    }

    /**
     * Get inventarioFisico
     *
     * @return \Buseta\BodegaBundle\Entity\InventarioFisico
     */
    public function getInventarioFisico()
    {
        return $this->inventarioFisico;
    }
}
