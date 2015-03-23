<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 22/03/15
 * Time: 4:35.
 */

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\Proveedor;
use Buseta\BodegaBundle\Entity\Tercero;
use Buseta\NomencladorBundle\Entity\Moneda;
use Buseta\UploadBundle\Entity\UploadResources;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var Moneda
     *
     * @Assert\NotBlank()
     */
    private $moneda;

    /**
     * @var int
     */
    private $creditoLimite;

    /**
     * @var string
     */
    private $observaciones;

    public function __construct(Proveedor $proveedor = null)
    {
        if ($proveedor === null) {
            return;
        }

        $tercero = $proveedor->getTercero();

        if ($tercero !== null) {
            $this->terceroId = $tercero->getId();
            $this->codigo = $tercero->getCodigo();
            $this->alias = $tercero->getAlias();
            $this->nombres = $tercero->getNombres();
            $this->apellidos = $tercero->getApellidos();
            $this->activo = $tercero->getActivo();
        }

        $this->proveedorId = $proveedor->getId();
        $this->moneda = $proveedor->getMoneda();
        $this->creditoLimite = $proveedor->getCreditoLimite();
        $this->observaciones = $proveedor->getObservaciones();
    }

    public function getTerceroData()
    {
        $tercero = new Tercero();

        $tercero->setId($this->terceroId);
        $tercero->setCodigo($this->codigo);
        $tercero->setAlias($this->alias);
        $tercero->setNombres($this->nombres);
        $tercero->setApellidos($this->apellidos);
        $tercero->setActivo($this->activo);

        return $tercero;
    }

    public function getProveedorData()
    {
        $proveedor = new Proveedor();

        $proveedor->setId($this->proveedorId);
        $proveedor->setMoneda($this->moneda);
        $proveedor->setCreditoLimite($this->creditoLimite);
        $proveedor->setObservaciones($this->observaciones);

        return $proveedor;
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
}
