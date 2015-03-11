<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 3/03/15
 * Time: 20:38
 */

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Diagnostico
 *
 * @ORM\Table(name="d_diagnostico")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\DiagnosticoRepository")
 */
class Diagnostico
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\Reporte")
     * @Assert\NotNull
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
     * @var string
     *
     * @ORM\Column(name="detalle_reporte", type="string", nullable=true)
     */
    private $detalleReporte;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\ObservacionDiagnostico", mappedBy="diagnostico", cascade={"all"})
     */
    private $observaciones;

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
     * Set detalleReporte
     *
     * @param string $detalleReporte
     * @return Diagnostico
     */
    public function setDetalleReporte($detalleReporte)
    {
        $this->detalleReporte = $detalleReporte;
    
        return $this;
    }

    /**
     * Get detalleReporte
     *
     * @return string 
     */
    public function getDetalleReporte()
    {
        return $this->detalleReporte;
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
        return "sdad";
    }
}