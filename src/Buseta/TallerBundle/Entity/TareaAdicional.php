<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Linea.
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
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\OrdenTrabajo", inversedBy="tareasAdicionales")
     */
    private $ordenTrabajo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Tarea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Tarea")
     * @Assert\NotNull
     */
    private $tarea;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_inicio", type="string", nullable=true)
     */
    private $horaInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_final", type="string", nullable=true)
     */
    private $horaFinal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_estimada", type="date")
     * @Assert\Date()
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $fechaEstimada;

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
    private $garantiaTarea;

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
     * Set horaInicio.
     *
     * @param string $horaInicio
     *
     * @return TareaAdicional
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio.
     *
     * @return string
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFinal.
     *
     * @param string $horaFinal
     *
     * @return TareaAdicional
     */
    public function setHoraFinal($horaFinal)
    {
        $this->horaFinal = $horaFinal;

        return $this;
    }

    /**
     * Get horaFinal.
     *
     * @return string
     */
    public function getHoraFinal()
    {
        return $this->horaFinal;
    }

    /**
     * Set fechaEstimada.
     *
     * @param \DateTime $fechaEstimada
     *
     * @return TareaAdicional
     */
    public function setFechaEstimada($fechaEstimada)
    {
        $this->fechaEstimada = $fechaEstimada;

        return $this;
    }

    /**
     * Get fechaEstimada.
     *
     * @return \DateTime
     */
    public function getFechaEstimada()
    {
        return $this->fechaEstimada;
    }

    /**
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return TareaAdicional
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set grupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     *
     * @return TareaAdicional
     */
    public function setGrupo(\Buseta\NomencladorBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo.
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set subgrupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo
     *
     * @return TareaAdicional
     */
    public function setSubgrupo(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo = null)
    {
        $this->subgrupo = $subgrupo;

        return $this;
    }

    /**
     * Get subgrupo.
     *
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * Set ordenTrabajo.
     *
     * @param \Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo
     *
     * @return TareaAdicional
     */
    public function setOrdenTrabajo(\Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo = null)
    {
        $this->ordenTrabajo = $ordenTrabajo;

        return $this;
    }

    /**
     * Get ordenTrabajo.
     *
     * @return \Buseta\TallerBundle\Entity\OrdenTrabajo
     */
    public function getOrdenTrabajo()
    {
        return $this->ordenTrabajo;
    }

    /**
     * Set tarea.
     *
     * @param \Buseta\NomencladorBundle\Entity\Tarea $tarea
     *
     * @return TareaAdicional
     */
    public function setTarea(\Buseta\NomencladorBundle\Entity\Tarea $tarea = null)
    {
        $this->tarea = $tarea;

        return $this;
    }

    /**
     * Get tarea.
     *
     * @return \Buseta\NomencladorBundle\Entity\Tarea
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set garantiaTarea.
     *
     * @param \Buseta\NomencladorBundle\Entity\GarantiaTarea $garantiaTarea
     *
     * @return TareaAdicional
     */
    public function setGarantiaTarea(\Buseta\NomencladorBundle\Entity\GarantiaTarea $garantiaTarea = null)
    {
        $this->garantiaTarea = $garantiaTarea;

        return $this;
    }

    /**
     * Get garantiaTarea.
     *
     * @return \Buseta\NomencladorBundle\Entity\GarantiaTarea
     */
    public function getGarantiaTarea()
    {
        return $this->garantiaTarea;
    }
}
