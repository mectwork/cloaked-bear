<?php
namespace Buseta\BodegaBundle\Form\Model;

class TerceroFilterModel
{
    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $nombres;

    /**
     * @var string
     */
    private $apellidos;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var boolean
     */
    private $cliente;

    /**
     * @var boolean
     */
    private $institucion;

    /**
     * @var boolean
     */
    private $proveedor;

    /**
     * @var boolean
     */
    private $persona;


    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return boolean
     */
    public function isCliente()
    {
        return $this->cliente;
    }

    /**
     * @param boolean $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
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
     * @return boolean
     */
    public function isInstitucion()
    {
        return $this->institucion;
    }

    /**
     * @param boolean $institucion
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;
    }

    /**
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return boolean
     */
    public function isProveedor()
    {
        return $this->proveedor;
    }

    /**
     * @param boolean $proveedor
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }

    /**
     * @return boolean
     */
    public function isPersona()
    {
        return $this->persona;
    }

    /**
     * @param boolean $persona
     */
    public function setPersona($persona)
    {
        $this->persona = $persona;
    }

} 