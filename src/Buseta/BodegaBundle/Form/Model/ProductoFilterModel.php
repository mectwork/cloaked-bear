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
     * @var \Buseta\BodegaBundle\Entity\Proveedor
     */
    private $proveedor;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Condicion
     */
    private $condicion;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     */
    private $subgrupo;

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
     * @return \Buseta\NomencladorBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo
     * @return ProductoFilterModel
     */
    public function setSubgrupo($subgrupo)
    {
        $this->subgrupo = $subgrupo;

        return $this;
    }
}
