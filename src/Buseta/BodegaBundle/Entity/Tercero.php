<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\TerceroModelInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tercero.
 *
 * @ORM\Table(name="d_tercero")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\TerceroRepository")
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
     * @var \HatueySoft\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="HatueySoft\UploadBundle\Entity\UploadResources", cascade={"all"})
     */
    private $foto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompra", mappedBy="tercero", cascade={"all"})
     */
    private $pedidoCompra;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\NecesidadMaterial", mappedBy="tercero", cascade={"all"})
     */
    private $necesidadMaterial;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Albaran", mappedBy="tercero", cascade={"all"})
     */
    private $albaran;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Bodega", mappedBy="responsable", cascade={"all"})
     */
    private $bodega;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string")
     * @Assert\NotBlank()
     */
    private $nombres;

    /**
     *
     * @ORM\ManyToOne(targetEntity="HatueySoft\SecurityBundle\Entity\User")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", nullable=true)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string")
     * @Assert\NotBlank()
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="cifNif", type="string", nullable=true)
     */
    private $cifNif;

    /**
     * @ORM\Column(name="cliente", type="boolean", nullable=true)
     */
    private $cliente;

    /**
     * @var \Buseta\BodegaBundle\Entity\Persona
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Persona", mappedBy="tercero", cascade={"persist", "remove"})
     */
    private $persona;

    /**
     * @var \Buseta\BodegaBundle\Entity\Proveedor
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Proveedor", mappedBy="tercero")
     */
    private $proveedor;

    /**
     * @ORM\Column(name="institucion", type="boolean", nullable=true)
     */
    private $institucion;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Direccion", mappedBy="tercero")
     */
    private $direcciones;

    /**
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     */
    private $web;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\MecanismoContacto", mappedBy="tercero", cascade={"remove","persist"})
     */
    private $mecanismosContacto;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PersonaContacto", mappedBy="tercero", cascade={"remove","persist"})
     */
    private $personaContacto;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pedidoCompra = new \Doctrine\Common\Collections\ArrayCollection();
        $this->albaran = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bodega = new \Doctrine\Common\Collections\ArrayCollection();
        $this->direcciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mecanismosContacto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->personaContacto = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Establece los valores desde el modelo en la entidad.
     *
     * @param TerceroModelInterface $model
     *
     * @return $this
     */
    public function setModelData(TerceroModelInterface $model)
    {
        $this->setFoto($model->getFoto());
        $this->setNombres($model->getNombres());
        $this->setApellidos($model->getApellidos());
        $this->setAlias($model->getAlias());
        $this->setCodigo($model->getCodigo());
        $this->setCifNif($model->getCifNif());
        $this->setActivo($model->getActivo());

        return $this;
    }


    /**
     * @param string $alias
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }
    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codigo.
     *
     * @param string $codigo
     *
     * @return Tercero
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo.
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombres.
     *
     * @param string $nombres
     *
     * @return Tercero
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres.
     *
     * @return string
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos.
     *
     * @param string $apellidos
     *
     * @return Tercero
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos.
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set alias.
     *
     * @param string $alias
     *
     * @return Tercero
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias.
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set cliente.
     *
     * @param boolean $cliente
     *
     * @return Tercero
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente.
     *
     * @return boolean
     * Set persona.
     *
     * @param boolean $persona
     *
     * @return Tercero
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set persona.
     *
     * @param \Buseta\BodegaBundle\Entity\Persona $persona
     *
     * @return Tercero
     */
    public function setPersona(\Buseta\BodegaBundle\Entity\Persona $persona)
    {
        $persona->setTercero($this);

        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona.
     *
     * @return \Buseta\BodegaBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set institucion.
     *
     * @param boolean $institucion
     *
     * @param boolean $proveedor
     *
     * @return Tercero
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * Get institucion.
     *
     * @return boolean
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * Add pedidoCompra.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     *
     * @return Tercero
     */
    public function addPedidoCompra(\Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra)
    {
        $this->pedidoCompra[] = $pedidoCompra;

        return $this;
    }

    /**
     * Remove pedidoCompra.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     */
    public function removePedidoCompra(\Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra)
    {
        $this->pedidoCompra->removeElement($pedidoCompra);
    }

    /**
     * Get pedidoCompra.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidoCompra()
    {
        return $this->pedidoCompra;
    }

    /**
     * Add necesidadMaterial.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial
     *
     * @return Tercero
     */
    public function addNecesidadMaterial(\Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial)
    {
        $this->necesidadMaterial[] = $necesidadMaterial;

        return $this;
    }

    /**
     * Remove necesidadMaterial.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial
     */
    public function removeNecesidadMaterial(\Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial)
    {
        $this->necesidadMaterial->removeElement($necesidadMaterial);
    }

    /**
     * Get necesidadMaterial.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNecesidadMaterial()
    {
        return $this->necesidadMaterial;
    }

    /**
     * Add albaran.
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     *
     * @return Tercero
     */
    public function addAlbaran(\Buseta\BodegaBundle\Entity\Albaran $albaran)
    {
        $this->albaran[] = $albaran;

        return $this;
    }

    /**
     * Remove albaran.
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     */
    public function removeAlbaran(\Buseta\BodegaBundle\Entity\Albaran $albaran)
    {
        $this->albaran->removeElement($albaran);
    }

    /**
     * Get albaran.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbaran()
    {
        return $this->albaran;
    }

    /**
     * Add direcciones.
     *
     * @param \Buseta\BodegaBundle\Entity\Direccion $direcciones
     *
     * @return Tercero
     */
    public function addDireccione(\Buseta\BodegaBundle\Entity\Direccion $direcciones)
    {
        $this->direcciones[] = $direcciones;

        return $this;
    }

    /**
     * Remove direcciones.
     *
     * @param \Buseta\BodegaBundle\Entity\Direccion $direcciones
     */
    public function removeDireccione(\Buseta\BodegaBundle\Entity\Direccion $direcciones)
    {
        $this->direcciones->removeElement($direcciones);
    }

    /**
     * Get direcciones.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDirecciones()
    {
        return $this->direcciones;
    }

    /**
     * Add mecanismosContacto.
     *
     * @param \Buseta\BodegaBundle\Entity\MecanismoContacto $mecanismosContacto
     *
     * @return Tercero
     */
    public function addMecanismosContacto(\Buseta\BodegaBundle\Entity\MecanismoContacto $mecanismosContacto)
    {
        $this->mecanismosContacto[] = $mecanismosContacto;

        return $this;
    }

    /**
     * Remove mecanismosContacto.
     *
     * @param \Buseta\BodegaBundle\Entity\MecanismoContacto $mecanismosContacto
     */
    public function removeMecanismosContacto(\Buseta\BodegaBundle\Entity\MecanismoContacto $mecanismosContacto)
    {
        $this->mecanismosContacto->removeElement($mecanismosContacto);
    }

    /**
     * Get mecanismosContacto.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMecanismosContacto()
    {
        return $this->mecanismosContacto;
    }

    /**
     * Set proveedor.
     *
     * @param \Buseta\BodegaBundle\Entity\Proveedor $proveedor
     *
     * @return Tercero
     */
    public function setProveedor(\Buseta\BodegaBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor.
     *
     * @return \Buseta\BodegaBundle\Entity\Proveedor
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set foto
     *
     * @param \HatueySoft\UploadBundle\Entity\UploadResources $foto
     * @return Tercero
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

    function __toString()
    {
        return sprintf('%s (%s)', trim($this->nombres . ' ' . $this->apellidos), $this->alias);
    }

    /**
     * Add bodega
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $bodega
     * @return Tercero
     */
    public function addBodega(\Buseta\BodegaBundle\Entity\Bodega $bodega)
    {
        $this->bodega[] = $bodega;

        return $this;
    }

    /**
     * Remove bodega
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $bodega
     */
    public function removeBodega(\Buseta\BodegaBundle\Entity\Bodega $bodega)
    {
        $this->bodega->removeElement($bodega);
    }

    /**
     * Get bodega
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBodega()
    {
        return $this->bodega;
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
     * Set email
     *
     * @param string $email
     * @return Tercero
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set web
     *
     * @param string $web
     * @return Tercero
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Add personaContacto
     *
     * @param \Buseta\BodegaBundle\Entity\PersonaContacto $personaContacto
     * @return Tercero
     */
    public function addPersonaContacto(\Buseta\BodegaBundle\Entity\PersonaContacto $personaContacto)
    {
        $this->personaContacto[] = $personaContacto;

        return $this;
    }

    /**
     * Remove personaContacto
     *
     * @param \Buseta\BodegaBundle\Entity\PersonaContacto $personaContacto
     */
    public function removePersonaContacto(\Buseta\BodegaBundle\Entity\PersonaContacto $personaContacto)
    {
        $this->personaContacto->removeElement($personaContacto);
    }

    /**
     * Get personaContacto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonaContacto()
    {
        return $this->personaContacto;
    }
}
