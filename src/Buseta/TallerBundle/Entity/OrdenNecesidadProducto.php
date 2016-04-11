<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OrdenNecesidadProducto.
 * @ORM\Table(name="d_orden_necesidad_producto")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\OrdenNecesidadProductoRepository")
 */
class OrdenNecesidadProducto
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
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\OrdenTrabajo")
     */
    private $ordentrabajo;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto")
     */
    private $producto;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\SalidaBodegaProducto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="salidaBodegaProducto_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $salidaBodegaProducto;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     * @Assert\NotBlank
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="seriales", type="string", nullable=true)
     */
    private $seriales;


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
     * Set cantidad
     *
     * @param integer $cantidad
     *
     * @return OrdenNecesidadProducto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set seriales
     *
     * @param string $seriales
     *
     * @return OrdenNecesidadProducto
     */
    public function setSeriales($seriales)
    {
        $this->seriales = $seriales;

        return $this;
    }

    /**
     * Get seriales
     *
     * @return string
     */
    public function getSeriales()
    {
        return $this->seriales;
    }

    /**
     * Set producto
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     *
     * @return OrdenNecesidadProducto
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
     * Set ordentrabajo
     *
     * @param \Buseta\TallerBundle\Entity\OrdenTrabajo $ordentrabajo
     *
     * @return OrdenNecesidadProducto
     */
    public function setOrdentrabajo(\Buseta\TallerBundle\Entity\OrdenTrabajo $ordentrabajo = null)
    {
        $this->ordentrabajo = $ordentrabajo;

        return $this;
    }

    /**
     * Get ordentrabajo
     *
     * @return \Buseta\TallerBundle\Entity\OrdenTrabajo
     */
    public function getOrdentrabajo()
    {
        return $this->ordentrabajo;
    }

    /**
     * Set salidaBodegaProducto
     *
     * @param \Buseta\BodegaBundle\Entity\SalidaBodegaProducto $salidaBodegaProducto
     *
     * @return OrdenNecesidadProducto
     */
    public function setSalidaBodegaProducto(
        \Buseta\BodegaBundle\Entity\SalidaBodegaProducto $salidaBodegaProducto = null
    ) {
        $this->salidaBodegaProducto = $salidaBodegaProducto;

        return $this;
    }

    /**
     * Get salidaBodegaProducto
     *
     * @return \Buseta\BodegaBundle\Entity\SalidaBodegaProducto
     */
    public function getSalidaBodegaProducto()
    {
        return $this->salidaBodegaProducto;
    }
}
