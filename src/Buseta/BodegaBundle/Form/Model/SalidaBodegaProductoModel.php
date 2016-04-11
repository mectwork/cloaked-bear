<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\SalidaBodegaProducto;
use Buseta\BodegaBundle\Entity\SalidaBodega;
use Buseta\BodegaBundle\Entity\Producto;
use Symfony\Component\Validator\Constraints as Assert;

class SalidaBodegaProductoModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Producto
     *
     * @Assert\NotNull()
     */
    private $producto;

    /**
     * @var integer
     *
     */
    private $cantidad;

    /**
     * @var SalidaBodega
     */
    private $salida;

    /**
     * @var array
     *
     */
    private $seriales;

    public function __construct(SalidaBodegaProducto $entity = null)
    {
        if ($entity === null) {
            return;
        }

        $this->id = $entity->getId();
        $this->producto = $entity->getProducto();
        $this->cantidad = $entity->getCantidad();
        $this->salida = $entity->getSalida();
        $this->seriales = explode(',', $entity->getSeriales());
    }

    /**
     * @return id
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
     * @return Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param Producto $producto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    /**
     * @return Salida
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * @param Salida $salida
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;
    }

    /**
     * @return array
     */
    public function getSeriales()
    {
        return $this->seriales;
    }

    /**
     * @param array $seriales
     */
    public function setSeriales($seriales)
    {
        $this->seriales = $seriales;
    }

    /**
     * @return cantidad
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function getSalidaBodegaProductoData()
    {
        $salidaBodegaProducto = new SalidaBodegaProducto();

        $salidaBodegaProducto->setId($this->getId());
        $salidaBodegaProducto->setSalida($this->getSalida());
        $salidaBodegaProducto->setCantidad($this->getCantidad());
        $salidaBodegaProducto->setProducto($this->getProducto());

        $seriales = implode(',', $this->getSeriales());
//        $ser_string = '';
//        foreach ($this->getSeriales() as $serial) {
//            if($ser_string != '')
//                $ser_string = $ser_string.",";
//            $ser_string = $ser_string.$serial;
//        }
        $salidaBodegaProducto->setSeriales($seriales);

        return $salidaBodegaProducto;
    }

}
