<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MantenimientoPreventivo
 *
 * @ORM\Table(name="d_mantenimiento_preventivo")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\MantenimientoPreventivoRepository")
 */
class MantenimientoPreventivo
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
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo")
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Tarea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Tarea")
     */
    private $tarea;

    /**
     * @var \Buseta\BusesBundle\Entity\Autobus
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     */
    private $autobus;

    /**
     * @var integer
     *
     * @ORM\Column(name="kilometraje", type="integer")
     */
    private $kilometraje;

    /**
     * @var string
     *
     * @ORM\Column(name="horas", type="string", nullable=true)
     */
    private $horas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date", nullable=true)
     */
    private $fechaFinal;


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
     * Set kilometraje
     *
     * @param integer $kilometraje
     * @return MantenimientoPreventivo
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;
    
        return $this;
    }

    /**
     * Get kilometraje
     *
     * @return integer 
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return MantenimientoPreventivo
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    
        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     * @return MantenimientoPreventivo
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
    
        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set grupo
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     * @return MantenimientoPreventivo
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
     * @return MantenimientoPreventivo
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
     * Set tarea
     *
     * @param \Buseta\NomencladorBundle\Entity\Tarea $tarea
     * @return MantenimientoPreventivo
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
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return MantenimientoPreventivo
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
     * @return string
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * @param string $horas
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;
    }
}