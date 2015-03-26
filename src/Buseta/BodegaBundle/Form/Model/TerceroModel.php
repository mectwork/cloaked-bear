<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\BodegaBundle\Form\Model\TerceroModelInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TerceroModel.
 */
class TerceroModel implements TerceroModelInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $codigo;

    /**
     * @var \Buseta\UploadBundle\Entity\UploadResources
     */
    private $foto;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $nombres;

    /**
     * @var string
     *
     */
    private $apellidos;

    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    private $alias;

    /**
     * @var \Buseta\SecurityBundle\Entity\User
     */
    private $usuario;

    /**
     * @var boolean
     */
    private $activo;


    /**
     * Constructor.
     *
     * @param Tercero $tercero
     */
    public function __construct(Tercero $tercero = null)
    {
        if ($tercero !== null) {
            $this->id = $tercero->getId();
            $this->codigo = $tercero->getCodigo();
            $this->usuario = $tercero->getUsuario();
            $this->nombres = $tercero->getNombres();
            $this->apellidos = $tercero->getApellidos();
            $this->alias = $tercero->getAlias();
            $this->foto = $tercero->getFoto();
            $this->activo = $tercero->getActivo();
        }
    }

    /**
     * Get Tercero entity data.
     *
     * @return Tercero
     */
    public function getEntityData()
    {
        $tercero = new Tercero();
        $tercero->setAlias($this->getAlias());
        $tercero->setNombres($this->getNombres());
        $tercero->setApellidos($this->getApellidos());
        $tercero->setCodigo($this->getCodigo());
        $tercero->setFoto($this->getFoto());
        $tercero->setUsuario($this->getUsuario());
        $tercero->setActivo($this->getActivo());

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
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
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
     * @return \Buseta\UploadBundle\Entity\UploadResources
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param \Buseta\UploadBundle\Entity\UploadResources $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
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
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param \Buseta\SecurityBundle\Entity\User $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}
