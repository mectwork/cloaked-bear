<?php

namespace Buseta\BodegaBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BitacoraEventModel
 *
 * @package Buseta\BodegaBundle\Event
 */
class BitacoraEventModel
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $warehouse;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     *
     * @Assert\NotNull()
     */
    private $product;

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
     * @var integer
     */
    private $quantityOrder;

    /**
     * @var string
     */
    private $movementType;

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
     * @return int
     */
    public function getQuantityOrder()
    {
        return $this->quantityOrder;
    }

    /**
     * @param int $quantityOrder
     */
    public function setQuantityOrder($quantityOrder)
    {
        $this->quantityOrder = $quantityOrder;
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
