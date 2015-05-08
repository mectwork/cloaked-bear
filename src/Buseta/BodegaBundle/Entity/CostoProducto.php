<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CostoProducto.
 *
 * @ORM\Table(name="d_producto_costo")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\CostoProductoRepository")
 */
class CostoProducto
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
     * @var float
     *
     * @ORM\Column(name="costo", type="decimal", scale=2)
     * @Assert\NotBlank()
     */
    private $costo;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $proveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_alternativo", type="string", length=32, nullable=true)
     */
    private $codigoAlternativo;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="costoProducto")
     * @Assert\NotNull
     */
    private $producto;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

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
     * Set costo.
     *
     * @param string $costo
     *
     * @return CostoProducto
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo.
     *
     * @return string
     */
    public function getCosto()
    {
        return $this->costo;
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
     * Set producto.
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     *
     * @return CostoProducto
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
     * Set proveedor
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $proveedor
     *
     * @return CostoProducto
     */
    public function setProveedor(\Buseta\BodegaBundle\Entity\Tercero $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set codigoAlternativo
     *
     * @param string $codigoAlternativo
     * @return CostoProducto
     */
    public function setCodigoAlternativo($codigoAlternativo)
    {
        $this->codigoAlternativo = $codigoAlternativo;

        return $this;
    }

    /**
     * Get codigoAlternativo
     *
     * @return string
     */
    public function getCodigoAlternativo()
    {
        return $this->codigoAlternativo;
    }
}
