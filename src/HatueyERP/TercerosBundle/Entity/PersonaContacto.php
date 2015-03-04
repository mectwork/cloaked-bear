<?php

namespace HatueyERP\TercerosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PersonaContacto
 *
 * @ORM\Table(name="c_tercero_persona_contacto")
 * @ORM\Entity
 */
class PersonaContacto
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
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=255)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono2", type="string", nullable=true)
     */
    private $telefono2;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    private $email;

    /**
     * @var \Buseta\NomencladorBundle\Entity\NParentesco
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\NParentesco")
     */
    private $parentesco;

    /**
     * @ORM\ManyToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Direccion")
     */
    private $direccion;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Tercero", inversedBy="personasContacto")
     */
    private $tercero;

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
     * @return PersonaContacto
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return PersonaContacto
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
     * Set telefono
     *
     * @param string $telefono
     * @return PersonaContacto
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
     * @return PersonaContacto
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
     * @return PersonaContacto
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
     * Set email
     *
     * @param string $email
     * @return PersonaContacto
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
     * Set parentesco
     *
     * @param \Olimpiada\NomencladorBundle\Entity\NParentesco $parentesco
     * @return PersonaContacto
     */
    public function setParentesco(\Olimpiada\NomencladorBundle\Entity\NParentesco $parentesco = null)
    {
        $this->parentesco = $parentesco;

        return $this;
    }

    /**
     * Get parentesco
     *
     * @return \Olimpiada\NomencladorBundle\Entity\NParentesco 
     */
    public function getParentesco()
    {
        return $this->parentesco;
    }

    /**
     * Set direccion
     *
     * @param \HatueyERP\TercerosBundle\Entity\Direccion $direccion
     * @return PersonaContacto
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
     * Set tercero
     *
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     * @return PersonaContacto
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
}
