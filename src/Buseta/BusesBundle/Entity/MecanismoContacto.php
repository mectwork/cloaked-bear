<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MecanismoContacto.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MecanismoContacto
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="tercero", type="object")
     */
    private $tercero;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="direccion", type="object")
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=30)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255)
     */
    private $fax;

    /**
     * @var boolean
     *
     * @ORM\Column(name="direccionEnvio", type="boolean")
     */
    private $direccionEnvio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return MecanismoContacto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set tercero.
     *
     * @param \stdClass $tercero
     *
     * @return MecanismoContacto
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero.
     *
     * @return \stdClass
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * Set direccion.
     *
     * @param \stdClass $direccion
     *
     * @return MecanismoContacto
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion.
     *
     * @return \stdClass
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono.
     *
     * @param string $telefono
     *
     * @return MecanismoContacto
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono.
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set fax.
     *
     * @param string $fax
     *
     * @return MecanismoContacto
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax.
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set direccionEnvio.
     *
     * @param boolean $direccionEnvio
     *
     * @return MecanismoContacto
     */
    public function setDireccionEnvio($direccionEnvio)
    {
        $this->direccionEnvio = $direccionEnvio;

        return $this;
    }

    /**
     * Get direccionEnvio.
     *
     * @return boolean
     */
    public function getDireccionEnvio()
    {
        return $this->direccionEnvio;
    }

    /**
     * Set activo.
     *
     * @param boolean $activo
     *
     * @return MecanismoContacto
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
}
