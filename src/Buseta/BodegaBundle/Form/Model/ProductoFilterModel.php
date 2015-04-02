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
    private $nombre;

    /**
     * @var \Buseta\BodegaBundle\Entity\CategoriaProducto
     */
    private $categoriaProducto;

    /**
     * @var \Buseta\NomencladorBundle\Entity\UOM
     */
    private $uom;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Condicion
     */
    private $condicion;

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