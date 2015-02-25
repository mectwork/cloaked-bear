<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Linea
 *
 * @ORM\Table(name="d_tarea_adicional")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\TareaAdicionalRepository")
 */
class TareaAdicional
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
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo")
     */
    private $grupo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupo;

    /**
     * @var \Buseta\TallerBundle\Entity\OrdenTrabajo
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\OrdenTrabajo", inversedBy="tarea_adicional")
     */
    private $orden_trabajo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Tarea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Tarea")
     */
    private $tarea;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_inicio", type="string", nullable=true)
     */
    private $hora_inicio;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_final", type="string", nullable=true)
     */
    private $hora_final;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_estimada", type="date")
     * @Assert\Date()
     */
    private $fecha_estimada;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    private $descripcion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\GarantiaTarea")
     */
    private $garantias_tareas;
    

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
     * Set hora_inicio
     *
     * @param string $horaInicio
     * @return TareaAdicional
     */
    public function setHoraInicio($horaInicio)
    {
        $this->hora_inicio = $horaInicio;
    
        return $this;
    }

    /**
     * Get hora_inicio
     *
     * @return string 
     */
    public function getHoraInicio()
    {
        return $this->hora_inicio;
    }

    /**
     * Set hora_final
     *
     * @param string $horaFinal
     * @return TareaAdicional
     */
    public function setHoraFinal($horaFinal)
    {
        $this->hora_final = $horaFinal;
    
        return $this;
    }

    /**
     * Get hora_final
     *
     * @return string 
     */
    public function getHoraFinal()
    {
        return $this->hora_final;
    }

    /**
     * Set fecha_estimada
     *
     * @param \DateTime $fechaEstimada
     * @return TareaAdicional
     */
    public function setFechaEstimada($fechaEstimada)
    {
        $this->fecha_estimada = $fechaEstimada;
    
        return $this;
    }

    /**
     * Get fecha_estimada
     *
     * @return \DateTime 
     */
    public function getFechaEstimada()
    {
        return $this->fecha_estimada;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return TareaAdicional
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set grupo
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     * @return TareaAdicional
     */
    public function setGrupo(\Buseta\NomencladorBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;
    
        return $this;
    }

    /**
     * Get grupo
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set subgrupo
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo
     * @return TareaAdicional
     */
    public function setSubgrupo(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo = null)
    {
        $this->subgrupo = $subgrupo;
    
        return $this;
    }

    /**
     * Get subgrupo
     *
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo 
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * Set orden_trabajo
     *
     * @param \Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo
     * @return TareaAdicional
     */
    public function setOrdenTrabajo(\Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo = null)
    {
        $this->orden_trabajo = $ordenTrabajo;
    
        return $this;
    }

    /**
     * Get orden_trabajo
     *
     * @return \Buseta\TallerBundle\Entity\OrdenTrabajo 
     */
    public function getOrdenTrabajo()
    {
        return $this->orden_trabajo;
    }

    /**
     * Set tarea
     *
     * @param \Buseta\NomencladorBundle\Entity\Tarea $tarea
     * @return TareaAdicional
     */
    public function setTarea(\Buseta\NomencladorBundle\Entity\Tarea $tarea = null)
    {
        $this->tarea = $tarea;
    
        return $this;
    }

    /**
     * Get tarea
     *
     * @return \Buseta\NomencladorBundle\Entity\Tarea 
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set garantias_tareas
     *
     * @param \Buseta\NomencladorBundle\Entity\GarantiaTarea $garantiasTareas
     * @return TareaAdicional
     */
    public function setGarantiasTareas(\Buseta\NomencladorBundle\Entity\GarantiaTarea $garantiasTareas = null)
    {
        $this->garantias_tareas = $garantiasTareas;
    
        return $this;
    }

    /**
     * Get garantias_tareas
     *
     * @return \Buseta\NomencladorBundle\Entity\GarantiaTarea 
     */
    public function getGarantiasTareas()
    {
        return $this->garantias_tareas;
    }
}