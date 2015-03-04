<?php

namespace HatueyERP\TercerosBundle\Form\Model;


use HatueyERP\TercerosBundle\Entity\Direccion;

class DireccionModel implements TercerosModelInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $calle2;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $codigoPostal;

    /**
     * @var string
     */
    private $localidad;

    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $pais = 'CR';

    /**
     * @param Direccion $direccion
     */
    function __construct(Direccion $direccion = null)
    {
        if ($direccion) {
            $this->id       = $direccion->getId();
            $this->calle    = $direccion->getCalle();
            $this->calle2   = $direccion->getCalle2();
            $this->nombre   = $direccion->getNombre();
            $this->codigoPostal = $direccion->getCodigoPostal();
            $this->localidad    = $direccion->getLocalidad();
            $this->region       = $direccion->getRegion();
            $this->pais         = $direccion->getPais();

            if ($direccion->getTercero()) {
                $this->tercero = $direccion->getTercero();
            }
        }
    }

    /**
     * @return Direccion
     */
    function getEntityData()
    {
        $direccion = new Direccion();
        $direccion->setCalle($this->getCalle());
        $direccion->setCalle2($this->getCalle2());
        $direccion->setNombre($this->getNombre());
        $direccion->setCodigoPostal($this->getCodigoPostal());
        $direccion->setLocalidad($this->getLocalidad());
        $direccion->setRegion($this->getRegion());
        $direccion->setPais($this->getPais());
        $direccion->setTercero($this->getTercero());

        return $direccion;
    }

    /**
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * @param string $calle
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;
    }

    /**
     * @return string
     */
    public function getCalle2()
    {
        return $this->calle2;
    }

    /**
     * @param string $calle2
     */
    public function setCalle2($calle2)
    {
        $this->calle2 = $calle2;
    }

    /**
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * @param string $codigoPostal
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;
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
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * @param string $localidad
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param string $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return sprintf('%s - %s - %s - %s',
            $this->calle,
            $this->calle2,
            $this->localidad,
            $this->region);
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return \HatueyERP\TercerosBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }
}