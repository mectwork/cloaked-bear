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
     * @var \Buseta\UploadBundle\Entity\UploadResources
     *
     * @ORM\OneToOne(targetEntity="Buseta\UploadBundle\Entity\UploadResources", cascade={"all"})
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
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Albaran", mappedBy="tercero", cascade={"all"})
     */
    private $albaran;

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
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
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
     */
    private $alias;

    /**
     * @ORM\Column(name="cliente", type="boolean", nullable=true)
     */
    private $cliente;

    /**
     * @ORM\Column(name="persona", type="boolean", nullable=true)
     */
    private $persona;

    /**
     * @ORM\Column(name="institucion", type="boolean", nullable=true)
     */
    private $institucion;

    /**
     * @ORM\Column(name="proveedor", type="boolean", nullable=true)
     */
    private $proveedor;

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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\MecanismoContacto", mappedBy="tercero", cascade={"remove","persist"})
     */
    private $mecanismosContacto;

    /**
     * @var \Buseta\BodegaBundle\Entity\Proveedor
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Proveedor", mappedBy="tercero")
     */
    private $proveedor2;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pedidoCompra = new \Doctrine\Common\Collections\ArrayCollection();
        $this->albaran = new \Doctrine\Common\Collections\ArrayCollection();
        $this->direcciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mecanismosContacto = new \Doctrine\Common\Collections\ArrayCollection();
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
        $this->setActivo($model->getActivo());

        return $this;
    }

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
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set persona.
     *
     * @param boolean $persona
     *
     * @return Tercero
     */
    public function setPersona($persona)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona.
     *
     * @return boolean
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
     * Set proveedor.
     *
     * @param boolean $proveedor
     *
     * @return Tercero
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor.
     *
     * @return boolean
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set activo.
     *
     * @param boolean $activo
     *
     * @return Tercero
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo.
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
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
     * Set proveedor2.
     *
     * @param \Buseta\BodegaBundle\Entity\Proveedor $proveedor2
     *
     * @return Tercero
     */
    public function setProveedor2(\Buseta\BodegaBundle\Entity\Proveedor $proveedor2 = null)
    {
        $this->proveedor2 = $proveedor2;

        return $this;
    }

    /**
     * Get proveedor2.
     *
     * @return \Buseta\BodegaBundle\Entity\Proveedor
     */
    public function getProveedor2()
    {
        return $this->proveedor2;
    }


    /**
     * Set foto
     *
     * @param \Buseta\UploadBundle\Entity\UploadResources $foto
     * @return Tercero
     */
    public function setFoto(\Buseta\UploadBundle\Entity\UploadResources $foto = null)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return \Buseta\UploadBundle\Entity\UploadResources 
     */
    public function getFoto()
    {
        return $this->foto;
    }
}