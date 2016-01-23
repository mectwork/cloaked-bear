<?php

namespace Buseta\CombustibleBundle\Form\Model;

use Buseta\CombustibleBundle\Entity\ConfiguracionMarchamo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ConfiguracionMarchamoModel
 * @package Buseta\CombustibleBundle\Form\Model
 */
class ConfiguracionMarchamoModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     * @Assert\NotNull
     */
    private $bodega;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     * @Assert\NotNull
     */
    private $producto;


    /**
     * ConfiguracionMarchamoModel constructor.
     */
    public function __construct(ConfiguracionMarchamo $conf = null)
    {
        if ($conf) {
            $this->id = $conf->getId();
            $this->producto = $conf->getProducto();
            $this->bodega = $conf->getBodega();
        }
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getBodega()
    {
        return $this->bodega;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Bodega $bodega
     */
    public function setBodega($bodega)
    {
        $this->bodega = $bodega;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Producto
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     */
    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    /**
     * @return int
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
}
