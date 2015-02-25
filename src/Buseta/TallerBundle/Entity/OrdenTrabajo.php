<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Linea
 *
 * @ORM\Table(name="d_orden_trabajo")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\OrdenTrabajoRepository")
 */
class OrdenTrabajo
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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $realizada_por;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     */
    private $autobus;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="diagnostico", type="string", nullable=false)
     */
    private $diagnostico;

    /**
     * @var string
     *
     * @ORM\Column(name="prioridad", type="string", nullable=false)
     */
    private $prioridad;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", nullable=false)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $ayudante;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\TareaAdicional", mappedBy="orden_trabajo", cascade={"all"})
     */
    private $tarea_adicional;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date")
     * @Assert\Date()
     */
    private $fecha_inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date")
     * @Assert\Date()
     */
    private $fecha_final;

    /**
     * @var string
     *
     * @ORM\Column(name="duracion_dias", type="string", nullable=false)
     */
    private $duracion_dias;

    /**
     * @var string
     *
     * @ORM\Column(name="duracion_horas_laboradas", type="string", nullable=false)
     */
    private $duracion_horas_laboradas;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tarea_adicional = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNumero();
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
     * Set numero
     *
     * @param string $numero
     * @return OrdenTrabajo
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set diagnostico
     *
     * @param string $diagnostico
     * @return OrdenTrabajo
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;
    
        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return string 
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set prioridad
     *
     * @param string $prioridad
     * @return OrdenTrabajo
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    
        return $this;
    }

    /**
     * Get prioridad
     *
     * @return string 
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return OrdenTrabajo
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return OrdenTrabajo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fecha_inicio
     *
     * @param \DateTime $fechaInicio
     * @return OrdenTrabajo
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fecha_inicio = $fechaInicio;
    
        return $this;
    }

    /**
     * Get fecha_inicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set fecha_final
     *
     * @param \DateTime $fechaFinal
     * @return OrdenTrabajo
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fecha_final = $fechaFinal;
    
        return $this;
    }

    /**
     * Get fecha_final
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fecha_final;
    }

    /**
     * Set duracion_dias
     *
     * @param string $duracionDias
     * @return OrdenTrabajo
     */
    public function setDuracionDias($duracionDias)
    {
        $this->duracion_dias = $duracionDias;
    
        return $this;
    }

    /**
     * Get duracion_dias
     *
     * @return string 
     */
    public function getDuracionDias()
    {
        return $this->duracion_dias;
    }

    /**
     * Set duracion_horas_laboradas
     *
     * @param string $duracionHorasLaboradas
     * @return OrdenTrabajo
     */
    public function setDuracionHorasLaboradas($duracionHorasLaboradas)
    {
        $this->duracion_horas_laboradas = $duracionHorasLaboradas;
    
        return $this;
    }

    /**
     * Get duracion_horas_laboradas
     *
     * @return string 
     */
    public function getDuracionHorasLaboradas()
    {
        return $this->duracion_horas_laboradas;
    }

    /**
     * Set realizada_por
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $realizadaPor
     * @return OrdenTrabajo
     */
    public function setRealizadaPor(\Buseta\BodegaBundle\Entity\Tercero $realizadaPor = null)
    {
        $this->realizada_por = $realizadaPor;
    
        return $this;
    }

    /**
     * Get realizada_por
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero 
     */
    public function getRealizadaPor()
    {
        return $this->realizada_por;
    }

    /**
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return OrdenTrabajo
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
     * Set ayudante
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $ayudante
     * @return OrdenTrabajo
     */
    public function setAyudante(\Buseta\BodegaBundle\Entity\Tercero $ayudante = null)
    {
        $this->ayudante = $ayudante;
    
        return $this;
    }

    /**
     * Get ayudante
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero 
     */
    public function getAyudante()
    {
        return $this->ayudante;
    }

    /**
     * Add tarea_adicional
     *
     * @param \Buseta\TallerBundle\Entity\TareaAdicional $tareaAdicional
     * @return OrdenTrabajo
     */
    public function addTareaAdicional(\Buseta\TallerBundle\Entity\TareaAdicional $tareaAdicional)
    {
        $tareaAdicional->setOrdenTrabajo($this);
        $this->tarea_adicional[] = $tareaAdicional;
    
        return $this;
    }

    /**
     * Remove tarea_adicional
     *
     * @param \Buseta\TallerBundle\Entity\TareaAdicional $tareaAdicional
     */
    public function removeTareaAdicional(\Buseta\TallerBundle\Entity\TareaAdicional $tareaAdicional)
    {
        $this->tarea_adicional->removeElement($tareaAdicional);
    }

    /**
     * Get tarea_adicional
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTareaAdicional()
    {
        return $this->tarea_adicional;
    }
}