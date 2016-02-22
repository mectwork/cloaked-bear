<?php

namespace Buseta\BodegaBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BitacoraSerialEventModel
 *
 * @package Buseta\BodegaBundle\Model
 */
class BitacoraSerialEventModel
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     *
     * @Assert\NotNull()
     */
    private $warehouse;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     *
     * @Assert\NotNull()
     */
    private $product;

    /**
     * @var \Buseta\BodegaBundle\Entity\ProductoSeriado
     *
     * @Assert\NotNull()
     */
    private $serialProduct;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $serial;

    /**
     * @var string
     */
    private $movementType;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $movementDate;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $movementQty;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var string
     */
    private $error;

    /**
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getWarehouse()
    {
        return $this->warehouse;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Bodega $warehouse
     */
    public function setWarehouse($warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Producto
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Producto $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\ProductoSeriado
     */
    public function getSerialProduct()
    {
        return $this->serialProduct;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\ProductoSeriado $serialProduct
     */
    public function setSerialProduct($serialProduct)
    {
        $this->serialProduct = $serialProduct;
    }

    /**
     * @return string
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * @param string $serial
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
    }

    /**
     * @return \DateTime
     */
    public function getMovementDate()
    {
        return $this->movementDate;
    }

    /**
     * @param \DateTime $movementDate
     */
    public function setMovementDate($movementDate)
    {
        $this->movementDate = $movementDate;
    }

    /**
     * @return int
     */
    public function getMovementQty()
    {
        return $this->movementQty;
    }

    /**
     * @param int $movementQty
     */
    public function setMovementQty($movementQty)
    {
        $this->movementQty = $movementQty;
    }

    /**
     * @return string
     */
    public function getMovementType()
    {
        return $this->movementType;
    }

    /**
     * @param string $movementType
     */
    public function setMovementType($movementType)
    {
        $this->movementType = $movementType;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }
}
