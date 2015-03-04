<?php

namespace HatueyERP\TercerosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HatueyERP\TercerosBundle\Form\Model\DireccionModel;

/**
 * Direccion
 *
 * @ORM\Table(name="c_direccion")
 * @ORM\Entity(repositoryClass="HatueyERP\TercerosBundle\Entity\Repository\DireccionRepository")
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
    protected $id;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Tercero", inversedBy="direccionesContacto")
     * @ORM\JoinColumn(onDelete="CASCADE", name="tercero_id")
     */
    private $tercero;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="calle2", type="string", nullable=true)
     */
    private $calle2;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_postal", type="string", nullable=true)
     */
    private $codigoPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="localidad", type="string", nullable=true)
     */
    private $localidad;

    /**
     * @var string
     *
     * @ORM\Column(name="pais", type="string")
     */
    private $pais;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", nullable=true)
     */
    private $region;


    /**
     * @param DireccionModel $model
     * @return $this
     */
    public function setModelData(DireccionModel $model)
    {
        $this->tercero      = $model->getTercero();
        $this->calle        = $model->getCalle();
        $this->calle2       = $model->getCalle2();
        $this->nombre       = $model->getNombre();
        $this->codigoPostal = $model->getCodigoPostal();
        $this->localidad    = $model->getLocalidad();
        $this->pais         = $model->getPais();
        $this->region       = $model->getRegion();

        return $this;
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
     * Set calle
     *
     * @param string $calle
     * @return Direccion
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set calle2
     *
     * @param string $calle2
     * @return Direccion
     */
    public function setCalle2($calle2)
    {
        $this->calle2 = $calle2;

        return $this;
    }

    /**
     * Get calle2
     *
     * @return string 
     */
    public function getCalle2()
    {
        return $this->calle2;
    }

    /**
     * Set codigoPostal
     *
     * @param string $codigoPostal
     * @return Direccion
     */
    public function setCodigoPostal($codigoPostal)
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get codigoPostal
     *
     * @return string 
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return Direccion
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Direccion
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Direccion
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set tercero
     *
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     * @return Direccion
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
     * Set nombre
     *
     * @param string $nombre
     * @return Direccion
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
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s - %s - %s',
            $this->calle,
            $this->calle2,
            $this->localidad,
            $this->region
        );
    }
}
