<?php

namespace Buseta\BusesBundle\Form\Model;


use Buseta\BusesBundle\Entity\Chofer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ChoferFilterModel.
 */
class ChoferFilterModel
{
    /**
     * @var integer
     */
    private $id;

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
    private $cedula;

    /**
     * @var \Buseta\NomencladorBundle\Entity\EstadoCivil
     */
    private $estadoCivil;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Nacionalidad
     */
    private $nacionalidad;

    /**
     * Constructor
     */
    public function __construct(Chofer $chofer = null)
    {
        if ($chofer !== null) {
            $this->id = $chofer->getId();

            $this->nombres = $chofer->getNombres();
            $this->apellidos = $chofer->getApellidos();
            $this->cedula = $chofer->getCedula();

            if ($chofer->getEstadoCivil()) {
                $this->estadoCivil  = $chofer->getEstadoCivil();
            }
            if ($chofer->getNacionalidad()) {
                $this->nacionalidad  = $chofer->getNacionalidad();
            }
        }
    }

    /**
     * @return Chofer
     */
    public function getEntityData()
    {
        $chofer = new Chofer();
        $chofer->setNombres($this->getNombres());
        $chofer->setApellidos($this->getApellidos());
        $chofer->setCedula($this->getCedula());

        if ($this->getEstadoCivil() !== null) {
            $chofer->setEstadoCivil($this->getEstadoCivil());
        }
        if ($this->getNacionalidad() !== null) {
            $chofer->setNacionalidad($this->getNacionalidad());
        }

        return $chofer;
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
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * @param string $cedula
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\EstadoCivil
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\EstadoCivil $estadoCivil
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->estadoCivil = $estadoCivil;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Nacionalidad
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Nacionalidad $nacionalidad
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;
    }

}
