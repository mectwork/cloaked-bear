<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 3/03/15
 * Time: 20:38
 */

namespace Buseta\TallerBundle\Entity;

use Buseta\CoreBundle\Doctrine\DateTimeAwareTrait;
use Buseta\CoreBundle\Interfaces\DateTimeAwareInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Diagnostico
 *
 * @ORM\Table(name="d_diagnostico")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\DiagnosticoRepository")
 */
class Diagnostico implements DateTimeAwareInterface
{
    use DateTimeAwareTrait;

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
     * @ORM\Column(name="numero", type="string")
     * @Assert\NotBlank()
     */
    private $numero;

    /**
     * @var \Buseta\TallerBundle\Entity\OrdenTrabajo
     *
     * @ORM\OneToOne(targetEntity="Buseta\TallerBundle\Entity\OrdenTrabajo", mappedBy="diagnostico")
     */
    private $ordenTrabajo;

    /**
     * @var \Buseta\TallerBundle\Entity\Reporte
     *
     * @ORM\OneToOne(targetEntity="Buseta\TallerBundle\Entity\Reporte", inversedBy="diagnostico")
     */
    private $reporte;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     * @Assert\NotNull
     */
    private $autobus;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\ObservacionDiagnostico", mappedBy="diagnostico", cascade={"all"})
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string")
     * @Assert\NotBlank()
     */
    private $estado = 'BO';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->observaciones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return Diagnostico
     */
    public function setAutobus(\Buseta\BusesBundle\Entity\Autobus $autobus = null)
    {
        $this->autobus = $autobus;

        return $this;
    }

    /**
     * Get autobus
     *
     * @return \Buseta\BusesBundle\Entity\Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * Add observaciones
     *
     * @param \Buseta\TallerBundle\Entity\ObservacionDiagnostico $observaciones
     * @return Diagnostico
     */
    public function addObservacione(\Buseta\TallerBundle\Entity\ObservacionDiagnostico $observaciones)
    {
        $observaciones->setDiagnostico($this);
        $this->observaciones[] = $observaciones;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Remove observaciones
     *
     * @param \Buseta\TallerBundle\Entity\ObservacionDiagnostico $observaciones
     */
    public function removeObservacione(\Buseta\TallerBundle\Entity\ObservacionDiagnostico $observaciones)
    {
        $this->observaciones->removeElement($observaciones);
    }

    /**
     * Get observaciones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function __toString()
    {
        return $this->numero;
    }

    /**
     * Set reporte
     *
     * @param \Buseta\TallerBundle\Entity\Reporte $reporte
     * @return Diagnostico
     */
    public function setReporte(\Buseta\TallerBundle\Entity\Reporte $reporte = null)
    {
        $this->reporte = $reporte;

        return $this;
    }

    /**
     * Get reporte
     *
     * @return \Buseta\TallerBundle\Entity\Reporte
     */
    public function getReporte()
    {
        return $this->reporte;
    }



    /**
     * Set ordenTrabajo
     *
     * @param \Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo
     * @return Diagnostico
     */
    public function setOrdenTrabajo(\Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo = null)
    {
        $this->ordenTrabajo = $ordenTrabajo;

        return $this;
    }

    /**
     * Get ordenTrabajo
     *
     * @return \Buseta\TallerBundle\Entity\OrdenTrabajo
     */
    public function getOrdenTrabajo()
    {
        return $this->ordenTrabajo;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return Diagnostico
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
