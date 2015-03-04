<?php

namespace HatueyERP\TercerosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TerceroContactos
 *
 * @ORM\Table(name="c_tercero_mecanismo_contacto")
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
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Tercero", inversedBy="mecanismosContacto")
     * @ORM\JoinColumn(onDelete="CASCADE", name="tercero_id")
     */
    private $tercero;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Direccion
     *
     * @ORM\ManyToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Direccion", cascade={"persist","remove"})
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono2", type="string", length=255, nullable=true)
     */
    private $telefono2;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dir_envio", type="boolean", nullable=true)
     */
    private $dirEnvio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

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
     * Set nombre
     *
     * @param string $nombre
     * @return TerceroContacto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return TerceroContacto
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     * @return TerceroContacto
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string 
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return TerceroContacto
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set dirEnvio
     *
     * @param boolean $dirEnvio
     * @return TerceroContacto
     */
    public function setDirEnvio($dirEnvio)
    {
        $this->dirEnvio = $dirEnvio;

        return $this;
    }

    /**
     * Get dirEnvio
     *
     * @return boolean 
     */
    public function getDirEnvio()
    {
        return $this->dirEnvio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return TerceroContacto
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
     * Set tercero
     *
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     * @return TerceroContacto
     */
    public function setTercero(\HatueyERP\TercerosBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero
     *
     * @return \HatueyERP\TercerosBundle\Entity\Tercero 
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * Set direccion
     *
     * @param \HatueyERP\TercerosBundle\Entity\Direccion $direccion
     * @return TerceroContacto
     */
    public function setDireccion(\HatueyERP\TercerosBundle\Entity\Direccion $direccion = null)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return \HatueyERP\TercerosBundle\Entity\Direccion 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->nombre;
    }
}
