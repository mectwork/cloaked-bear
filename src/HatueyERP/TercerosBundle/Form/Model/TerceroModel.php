<?php

namespace HatueyERP\TercerosBundle\Form\Model;

use HatueyERP\TercerosBundle\Entity\Tercero;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tercero Model
 *
 */
class TerceroModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $identificador;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     */
    private $foto;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $nombres;

    /**
     * @var string
     */
    private $apellidos;

    /**
     * @var string
     */
    private $nombreComercial;

    /**
     * @var string
     */
    private $nombreFiscal;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $cifNif;

    /**
     * @var boolean
     */
    private $isPersona;

    /**
     * @var boolean
     */
    private $isCliente;

    /**
     * @var boolean
     */
    private $isProveedor;

    /**
     * @var boolean
     */
    private $isInstitucion;

    /**
     * @var boolean
     */
    private $activo = true;

    /**
     * Constructor
     */
    public function __construct(Tercero $tercero = null)
    {
        if ($tercero !== null) {
            $this->id               = $tercero->getId();
            $this->nombres          = $tercero->getNombres();
            $this->apellidos        = $tercero->getApellidos();
            $this->identificador    = $tercero->getIdentificador();
            $this->nombreComercial  = $tercero->getNombreComercial();
            $this->nombreFiscal     = $tercero->getNombreFiscal();
            $this->cifNif           = $tercero->getCifNif();
            $this->descripcion      = $tercero->getDescripcion();
            $this->activo           = $tercero->getActivo();
            if ($tercero->getFoto()) {
                $this->foto = $tercero->getFoto();
            }
        }
    }

    /**
     * @return Tercero
     */
    public function getEntityData()
    {
        $tercero = new Tercero();
        $tercero->setIdentificador($this->getIdentificador());
        $tercero->setNombres($this->getNombres());
        $tercero->setApellidos($this->getApellidos());
        $tercero->setNombreComercial($this->getNombreComercial());
        $tercero->setNombreFiscal($this->getNombreFiscal());
        $tercero->setCifNif($this->getCifNif());
        $tercero->setDescripcion($this->getDescripcion());
        $tercero->setActivo($this->isActivo());
        $tercero->setFoto($this->getFoto());

        return $tercero;
    }

    /**
     * @return boolean
     */
    public function isActivo()
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

    /**
     * @return string
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * @param string $identificador
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;
    }

    /**
     * @return boolean
     */
    public function isIsCliente()
    {
        return $this->isCliente;
    }

    /**
     * @param boolean $isCliente
     */
    public function setIsCliente($isCliente)
    {
        $this->isCliente = $isCliente;
    }

    /**
     * @return boolean
     */
    public function isIsInstitucion()
    {
        return $this->isInstitucion;
    }

    /**
     * @param boolean $isInstitucion
     */
    public function setIsInstitucion($isInstitucion)
    {
        $this->isInstitucion = $isInstitucion;
    }

    /**
     * @return boolean
     */
    public function isIsPersona()
    {
        return $this->isPersona;
    }

    /**
     * @param boolean $isPersona
     */
    public function setIsPersona($isPersona)
    {
        $this->isPersona = $isPersona;
    }

    /**
     * @return boolean
     */
    public function isIsProveedor()
    {
        return $this->isProveedor;
    }

    /**
     * @param boolean $isProveedor
     */
    public function setIsProveedor($isProveedor)
    {
        $this->isProveedor = $isProveedor;
    }

    /**
     * @return string
     */
    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    /**
     * @param string $nombreComercial
     */
    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;
    }

    /**
     * @return string
     */
    public function getNombreFiscal()
    {
        return $this->nombreFiscal;
    }

    /**
     * @param string $nombreFiscal
     */
    public function setNombreFiscal($nombreFiscal)
    {
        $this->nombreFiscal = $nombreFiscal;
    }

    /**
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
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
    public function __toString()
    {
        return $this->nombreComercial;
    }
}
