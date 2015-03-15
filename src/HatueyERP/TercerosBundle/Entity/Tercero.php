<?php

namespace HatueyERP\TercerosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HatueyERP\TercerosBundle\Form\Model\TerceroModel;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tercero
 *
 * @ORM\Table(name="c_tercero")
 * @ORM\Entity(repositoryClass="HatueyERP\TercerosBundle\Entity\Repository\TerceroRepository")
 */
class Tercero
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="identificador", type="string", nullable=true)
     * @Assert\NotBlank
     */
    private $identificador;

    /**
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="HatueySoft\UploadBundle\Entity\UploadResources", cascade={"persist", "remove"})
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string")
     * @Assert\NotBlank
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", nullable=true)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_comercial", type="string", nullable=true)
     */
    private $nombreComercial;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_fiscal", type="string", nullable=true)
     */
    private $nombreFiscal;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="cif_nif", type="string", nullable=true)
     */
    private $cifNif;

    /**
     * @ORM\Column(name="is_persona", type="boolean", nullable=true)
     */
    private $isPersona;

    /**
     * @ORM\Column(name="is_cliente", type="boolean", nullable=true)
     */
    private $isCliente;

    /**
     * @ORM\Column(name="is_proveedor", type="boolean", nullable=true)
     */
    private $isProveedor;

    /**
     * @ORM\Column(name="is_institucion", type="boolean", nullable=true)
     */
    private $isInstitucion;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Persona
     *
     * @ORM\OneToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Persona", mappedBy="tercero", cascade={"persist","remove"})
     */
    private $persona;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Cliente
     *
     * @ORM\OneToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Cliente", mappedBy="tercero", cascade={"persist","remove"})
     */
    private $cliente;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Proveedor
     *
     * @ORM\OneToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Proveedor", mappedBy="tercero", cascade={"persist","remove"})
     */
    private $proveedor;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Institucion
     *
     * @ORM\OneToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Institucion", mappedBy="tercero", cascade={"persist","remove"})
     */
    private $institucion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="HatueyERP\TercerosBundle\Entity\Direccion", mappedBy="tercero", cascade={"persist","remove"})
     */
    private $direccionesContacto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="HatueyERP\TercerosBundle\Entity\MecanismoContacto", mappedBy="tercero", cascade={"persist","remove"})
     */
    private $mecanismosContacto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="HatueyERP\TercerosBundle\Entity\PersonaContacto", mappedBy="tercero", cascade={"persist","remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $personasContacto;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->activo   = true;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identificador
     *
     * @param string $identificador
     * @return Tercero
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string 
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set foto
     *
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $foto
     * @return Persona
     */
    public function setFoto(\HatueySoft\UploadBundle\Entity\UploadResources $foto = null)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return \HatueySoft\UploadBundle\Entity\UploadResources
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Tercero
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Tercero
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set nombreComercial
     *
     * @param string $nombreComercial
     * @return Tercero
     */
    public function setNombreComercial($nombreComercial)
    {
        $this->nombreComercial = $nombreComercial;

        return $this;
    }

    /**
     * Get nombreComercial
     *
     * @return string 
     */
    public function getNombreComercial()
    {
        return $this->nombreComercial;
    }

    /**
     * Set nombreFiscal
     *
     * @param string $nombreFiscal
     * @return Tercero
     */
    public function setNombreFiscal($nombreFiscal)
    {
        $this->nombreFiscal = $nombreFiscal;

        return $this;
    }

    /**
     * Get nombreFiscal
     *
     * @return string 
     */
    public function getNombreFiscal()
    {
        return $this->nombreFiscal;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Tercero
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set cifNif
     *
     * @param string $cifNif
     * @return Tercero
     */
    public function setCifNif($cifNif)
    {
        $this->cifNif = $cifNif;

        return $this;
    }

    /**
     * Get cifNif
     *
     * @return string 
     */
    public function getCifNif()
    {
        return $this->cifNif;
    }

    /**
     * Set isPersona
     *
     * @param boolean $isPersona
     * @return Tercero
     */
    public function setIsPersona($isPersona)
    {
        $this->isPersona = $isPersona;

        return $this;
    }

    /**
     * Get isPersona
     *
     * @return boolean 
     */
    public function getIsPersona()
    {
        return $this->isPersona;
    }

    /**
     * Set persona
     *
     * @param \HatueyERP\TercerosBundle\Entity\Persona $persona
     * @return Tercero
     */
    public function setPersona(\HatueyERP\TercerosBundle\Entity\Persona $persona = null)
    {
        $persona->setTercero($this);

        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \HatueyERP\TercerosBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set isCliente
     *
     * @param boolean $isCliente
     * @return Tercero
     */
    public function setIsCliente($isCliente)
    {
        $this->isCliente = $isCliente;

        return $this;
    }

    /**
     * Get isCliente
     *
     * @return boolean 
     */
    public function getIsCliente()
    {
        return $this->isCliente;
    }

    /**
     * Set isProveedor
     *
     * @param boolean $isProveedor
     * @return Tercero
     */
    public function setIsProveedor($isProveedor)
    {
        $this->isProveedor = $isProveedor;

        return $this;
    }

    /**
     * Get isProveedor
     *
     * @return boolean 
     */
    public function getIsProveedor()
    {
        return $this->isProveedor;
    }

    /**
     * Set isInstitucion
     *
     * @param boolean $isInstitucion
     * @return Tercero
     */
    public function setIsInstitucion($isInstitucion)
    {
        $this->isInstitucion = $isInstitucion;

        return $this;
    }

    /**
     * Get isInstitucion
     *
     * @return boolean 
     */
    public function getIsInstitucion()
    {
        return $this->isInstitucion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Persona
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Add personasContacto
     *
     * @param \HatueyERP\TercerosBundle\Entity\PersonaContacto $personasContacto
     * @return Tercero
     */
    public function addPersonasContacto(\HatueyERP\TercerosBundle\Entity\PersonaContacto $personasContacto)
    {
        $personasContacto->setTercero($this);

        $this->personasContacto[] = $personasContacto;

        return $this;
    }

    /**
     * Remove personasContacto
     *
     * @param \HatueyERP\TercerosBundle\Entity\PersonaContacto $personasContacto
     */
    public function removePersonasContacto(\HatueyERP\TercerosBundle\Entity\PersonaContacto $personasContacto)
    {
        $personasContacto->setTercero(null);

        $this->personasContacto->removeElement($personasContacto);
    }

    /**
     * Get personasContacto
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersonasContacto()
    {
        return $this->personasContacto;
    }

    /**
     * Add mecanismosContacto
     *
     * @param \HatueyERP\TercerosBundle\Entity\MecanismoContacto $mecanismosContacto
     * @return Tercero
     */
    public function addMecanismosContacto(\HatueyERP\TercerosBundle\Entity\MecanismoContacto $mecanismosContacto)
    {
        $mecanismosContacto->setTercero($this);

        $this->mecanismosContacto[] = $mecanismosContacto;

        return $this;
    }

    /**
     * Remove mecanismosContacto
     *
     * @param \HatueyERP\TercerosBundle\Entity\MecanismoContacto $mecanismosContacto
     */
    public function removeMecanismosContacto(\HatueyERP\TercerosBundle\Entity\MecanismoContacto $mecanismosContacto)
    {
        $mecanismosContacto->setTercero(null);

        $this->mecanismosContacto->removeElement($mecanismosContacto);
    }

    /**
     * Get mecanismosContacto
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMecanismosContacto()
    {
        return $this->mecanismosContacto;
    }

    /**
     * Add direccionesContacto
     *
     * @param \HatueyERP\TercerosBundle\Entity\Direccion $direccionesContacto
     * @return Tercero
     */
    public function addDireccionesContacto(\HatueyERP\TercerosBundle\Entity\Direccion $direccionesContacto)
    {
        $direccionesContacto->setTercero($this);

        $this->direccionesContacto[] = $direccionesContacto;

        return $this;
    }

    /**
     * Remove direccionesContacto
     *
     * @param \HatueyERP\TercerosBundle\Entity\Direccion $direccionesContacto
     */
    public function removeDireccionesContacto(\HatueyERP\TercerosBundle\Entity\Direccion $direccionesContacto)
    {
        $direccionesContacto->setTercero(null);

        $this->direccionesContacto->removeElement($direccionesContacto);
    }

    /**
     * Get direccionesContacto
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDireccionesContacto()
    {
        return $this->direccionesContacto;
    }

    /**
     * @param TerceroModel $model
     * @return Tercero
     */
    public function setModelData(TerceroModel $model)
    {
        $this->identificador    = $model->getIdentificador();
        $this->nombres          = $model->getNombres();
        $this->apellidos        = $model->getApellidos();
        $this->nombreComercial  = $model->getNombreComercial();
        $this->nombreFiscal     = $model->getNombreFiscal();
        $this->cifNif           = $model->getCifNif();
        $this->descripcion      = $model->getDescripcion();
        $this->activo           = $model->isActivo();
        if ($model->getFoto()) {
            $this->foto = $model->getFoto();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nombreComercial;
    }

    /**
     * Set cliente
     *
     * @param \HatueyERP\TercerosBundle\Entity\Cliente $cliente
     * @return Tercero
     */
    public function setCliente(\HatueyERP\TercerosBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \HatueyERP\TercerosBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set proveedor
     *
     * @param \HatueyERP\TercerosBundle\Entity\Proveedor $proveedor
     * @return Tercero
     */
    public function setProveedor(\HatueyERP\TercerosBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \HatueyERP\TercerosBundle\Entity\Proveedor 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set institucion
     *
     * @param \HatueyERP\TercerosBundle\Entity\Institucion $institucion
     * @return Tercero
     */
    public function setInstitucion(\HatueyERP\TercerosBundle\Entity\Institucion $institucion = null)
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * Get institucion
     *
     * @return \HatueyERP\TercerosBundle\Entity\Institucion 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }
}
