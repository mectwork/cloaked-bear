<?php
namespace Buseta\BodegaBundle\Form\Model;

class BitSerialFilterModel
{
    /**
     * @var string
     */
    private $serial;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $almacen;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     */
    private $producto;

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
     * @return string
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * @param string
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;
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
}
