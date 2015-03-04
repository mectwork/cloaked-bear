<?php

namespace HatueyERP\TercerosBundle\Form\Model;


use HatueyERP\TercerosBundle\Entity\MecanismoContacto;

class MecanismoContactoModel implements TercerosModelInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $tercero;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Direccion
     */
    private $direccion;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $telefono2;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var boolean
     */
    private $dirEnvio;

    /**
     * @var boolean
     */
    private $activo;


    function __construct(MecanismoContacto $mecanismoContacto = null)
    {
        if  ($mecanismoContacto) {
            $this->id           = $mecanismoContacto->getId();
            $this->nombre       = $mecanismoContacto->getNombre();
            $this->telefono     = $mecanismoContacto->getTelefono();
            $this->telefono2    = $mecanismoContacto->getTelefono2();
            $this->fax          = $mecanismoContacto->getFax();
            $this->dirEnvio     = $mecanismoContacto->getDirEnvio();
            $this->activo       = $mecanismoContacto->getActivo();

            if ($mecanismoContacto->getDireccion()) {
                $this->direccion = $mecanismoContacto->getDireccion();
            }
            if ($mecanismoContacto->getTercero()) {
                $this->tercero = $mecanismoContacto->getTercero()->getId();
            }
        }
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
    public function isDirEnvio()
    {
        return $this->dirEnvio;
    }

    /**
     * @param boolean $dirEnvio
     */
    public function setDirEnvio($dirEnvio)
    {
        $this->dirEnvio = $dirEnvio;
    }

    /**
     * @return int
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param int $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * @param string $telefono2
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;
    }

    /**
     * @return int
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param int $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }
} 