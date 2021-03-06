<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Direccion.
 *
 * @ORM\Table(name="d_tercero_direccion")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Direccion
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
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="direcciones")
     */
    private $tercero;

    /**
     * @var \Buseta\BodegaBundle\Entity\PersonaContacto
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PersonaContacto", mappedBy="direccion")
     */
    private $pcontacto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=255, nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="codigoPostal", type="string", length=255, nullable=true)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", length=255, nullable=true)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string", length=255, nullable=true)
     */
    private $pais;

    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="decimal", nullable=true)
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="decimal", nullable=true)
     */
    private $longitud;

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
     * @return Direccion
     */
    public function setNombre($nombre = null)
    {
        $this->nombre = sprintf("%s - %s - %s",
            $this->getCalle(),
            $this->getLocalidad(),
            $this->getRegion()
        );

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
     * Set calle.
     *
     * @param string $calle
     *
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle.
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set codigoPostal.
     *
     * @param string $codigoPostal
     *
     * @return Direccion
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal.
     *
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set localidad.
     *
     * @param string $localidad
     *
     * @return Direccion
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad.
     *
     * @return string
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set pais.
     *
     * @param string $pais
     *
     * @return Direccion
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais.
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set region.
     *
     * @param string $region
     *
     * @return Direccion
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region.
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set tercero.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     *
     * @return Direccion
     */
    public function setTercero(\Buseta\BodegaBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateName()
    {
        $this->setNombre();
    }

    function __toString()
    {
        return $this->nombre;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pcontacto = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pcontacto
     *
     * @param \Buseta\BodegaBundle\Entity\PersonaContacto $pcontacto
     * @return Direccion
     */
    public function addPcontacto(\Buseta\BodegaBundle\Entity\PersonaContacto $pcontacto)
    {
        $this->pcontacto[] = $pcontacto;

        return $this;
    }

    /**
     * Remove pcontacto
     *
     * @param \Buseta\BodegaBundle\Entity\PersonaContacto $pcontacto
     */
    public function removePcontacto(\Buseta\BodegaBundle\Entity\PersonaContacto $pcontacto)
    {
        $this->pcontacto->removeElement($pcontacto);
    }

    /**
     * Get pcontacto
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPcontacto()
    {
        return $this->pcontacto;
    }

    /**
     * @return float
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * @param float $latitud
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * @param float $longitud
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

}
