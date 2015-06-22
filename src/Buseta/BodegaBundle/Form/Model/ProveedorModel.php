<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Proveedor;
use Buseta\NomencladorBundle\Entity\Moneda;

class ProveedorModel
{
    /**
     * @var integer
     */
    private $proveedorId;

    /**
     * @var integer
     */
    private $terceroId;

    /**
     * @var UploadResources
     */
    private $foto;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $codigo;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $nombres;

    /**
     * @var string
     */
    private $apellidos;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $alias;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var string
     */
    private $cifNif;

    /**
     * @var Moneda
     *
     * @Assert\NotNull()
     */
    private $moneda;

    /**
     * @var int
     */
    private $creditoLimite;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $web;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var array
     */
    private $marcas;


    public function __construct(Proveedor $proveedor = null)
    {
        if ($proveedor === null) {
            return;
        }

        $tercero = $proveedor->getTercero();

        if ($tercero !== null) {
            $this->terceroId = $tercero->getId();
            $this->codigo = $tercero->getCodigo();
            $this->foto = $tercero->getFoto();
            $this->alias = $tercero->getAlias();
            $this->nombres = $tercero->getNombres();
            $this->apellidos = $tercero->getApellidos();
            $this->activo = $tercero->getActivo();
            $this->cifNif = $tercero->getCifNif();
            $this->email = $tercero->getEmail();
            $this->web = $tercero->getWeb();
        }

        $this->proveedorId = $proveedor->getId();
        $this->moneda = $proveedor->getMoneda();
        $this->creditoLimite = $proveedor->getCreditoLimite();
        $this->observaciones = $proveedor->getObservaciones();
        $this->marcas = $proveedor->getMarcas();
    }

    public function getTerceroData()
    {
        $tercero = new Tercero();

        $tercero->setId($this->getTerceroId());
        $tercero->setFoto($this->getFoto());
        $tercero->setCodigo($this->getCodigo());
        $tercero->setAlias($this->getAlias());
        $tercero->setNombres($this->getNombres());
        $tercero->setApellidos($this->getApellidos());
        $tercero->setActivo($this->getActivo());
        $tercero->setCifNif($this->getCifNif());
        $tercero->setEmail($this->getEmail());
        $tercero->setWeb($this->getWeb());

        return $tercero;
    }

    public function getProveedorData()
    {
        $proveedor = new Proveedor();

        $proveedor->setId($this->getProveedorId());
        $proveedor->setMoneda($this->getMoneda());
        $proveedor->setCreditoLimite($this->getCreditoLimite());
        $proveedor->setObservaciones($this->getObservaciones());

        foreach ($this->marcas as $marca) {
            $proveedor->addMarca($marca);
        }

        return $proveedor;
    }

    /**
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

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
     * @return int
     */
    public function getCreditoLimite()
    {
        return $this->creditoLimite;
    }

    /**
     * @param int $creditoLimite
     */
    public function setCreditoLimite($creditoLimite)
    {
        $this->creditoLimite = $creditoLimite;
    }

    /**
     * @return UploadResources
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param UploadResources $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return int
     */
    public function getProveedorId()
    {
        return $this->proveedorId;
    }

    /**
     * @param int $proveedorId
     */
    public function setProveedorId($proveedorId)
    {
        $this->proveedorId = $proveedorId;
    }

    /**
     * @return int
     */
    public function getTerceroId()
    {
        return $this->terceroId;
    }

    /**
     * @param int $terceroId
     */
    public function setTerceroId($terceroId)
    {
        $this->terceroId = $terceroId;
    }

    /**
     * @return Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param Moneda $moneda
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;
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
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return string
     */
    public function getCifNif()
    {
        return $this->cifNif;
    }

    /**
     * @param string $cifNif
     */
    public function setCifNif($cifNif)
    {
        $this->cifNif = $cifNif;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * @param string $web
     */
    public function setWeb($web)
    {
        $this->web = $web;
    }

    /**
     * @return array
     */
    public function getMarcas()
    {
        return $this->marcas;
    }

    /**
     * @param array $marcas
     */
    public function setMarcas($marcas)
    {
        $this->marcas = $marcas;
    }

}
