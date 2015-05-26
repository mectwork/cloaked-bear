<?php
namespace Buseta\BodegaBundle\Form\Model;

class ProductoFilterModel
{
    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $codigoAlternativo;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \Buseta\BodegaBundle\Entity\CategoriaProducto
     */
    private $categoriaProducto;

    /**
     * @var \Buseta\BodegaBundle\Entity\Proveedor
     */
    private $proveedor;

    /**
     * @var \Buseta\NomencladorBundle\Entity\UOM
     */
    private $uom;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Condicion
     */
    private $condicion;

    /**
     * @return string
     */
    public function getCodigoAlternativo()
    {
        return $this->codigoAlternativo;
    }

    /**
     * @param string $codigoAlternativo
     */
    public function setCodigoAlternativo($codigoAlternativo)
    {
        $this->codigoAlternativo = $codigoAlternativo;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Proveedor
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Proveedor $proveedor
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\CategoriaProducto
     */
    public function getCategoriaProducto()
    {
        return $this->categoriaProducto;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\CategoriaProducto $categoriaProducto
     */
    public function setCategoriaProducto($categoriaProducto)
    {
        $this->categoriaProducto = $categoriaProducto;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Condicion
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Condicion $condicion
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\UOM
     */
    public function getUom()
    {
        return $this->uom;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\UOM $uom
     */
    public function setUom($uom)
    {
        $this->uom = $uom;
    }

} 