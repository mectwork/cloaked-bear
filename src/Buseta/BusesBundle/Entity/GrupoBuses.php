<?php

namespace Buseta\BusesBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;


/**
 * GrupoBuses
 *
 * @ORM\Table(name="d_grupobuses")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\GrupoBusesRepository")
 */
class GrupoBuses
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
     * @ORM\Column(name="color", type="string", length=7)
     */
    private $color;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BusesBundle\Entity\Autobus", mappedBy="grupobuses", cascade={"all"})
     */
    private $autobuses;

    /**
     * @var string
     *
     * @ORM\Column(name="colorTexto", type="string", length=7)
     */
    private $colorTexto;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->autobuses = new ArrayCollection();
    }

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
     * @return GrupoBuses
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
     * Set color
     *
     * @param string $color
     * @return GrupoBuses
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }



    /**
     * Set autobuses
     *
     * @param string $autobuses
     * @return GrupoBuses
     */
    public function setAutobuses($autobuses)
    {
        $this->autobuses = $autobuses;

        return $this;
    }

    /**
     * Get autobuses
     *
     * @return string
     */
    public function getAutobuses()
    {
        return $this->autobuses;
    }

    public function setColorTexto($colorTexto)
    {
        $this->colorTexto = $colorTexto;

        return $this;
    }

    /**
     * Get colorTexto.
     *
     * @return string
     */
    public function getColorTexto()
    {
        return $this->colorTexto;
    }

    public function __toString()
    {
        return sprintf( '%s', $this->getNombre() );
    }

}