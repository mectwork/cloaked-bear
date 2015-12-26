<?php

namespace Buseta\TallerBundle\Entity;

use HatueySoft\SecurityBundle\Doctrine\DateTimeAwareTrait;
use HatueySoft\SecurityBundle\Interfaces\DateTimeAwareInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Linea.
 *
 * @ORM\Table(name="d_orden_trabajo")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\OrdenTrabajoRepository")
 */
class OrdenTrabajo implements DateTimeAwareInterface
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
     * @var \Buseta\TallerBundle\Entity\Diagnostico
     *
     * @ORM\OneToOne(targetEntity="Buseta\TallerBundle\Entity\Diagnostico", inversedBy="ordenTrabajo")
     */
    private $diagnostico;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $realizadaPor;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $ayudante;

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
     * @ORM\Column(name="numero", type="string")
     * @Assert\NotBlank()
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="requision_materiales", type="string", nullable=true)
     */
    private $requisionMateriales;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $diagnosticadoPor;

    /**
     * @var string
     *
     * @ORM\Column(name="prioridad", type="string", nullable=true)
     * @Assert\Choice(choices={"rapida", "normal"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $prioridad;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="estado", type="string", nullable=true)
     */
    private $estado;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\TareaAdicional", mappedBy="ordenTrabajo", cascade={"all"})
     */
    private $tareasAdicionales;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     * @Assert\Date()
     * @Assert\NotNull()
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date", nullable=true)
     * @Assert\Date()
     */
    private $fechaFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="duracion_dias", type="integer", nullable=true)
     */
    private $duracionDias;

    /**
     * @var string
     *
     * @ORM\Column(name="duracion_horas_laboradas", type="integer", nullable=true)
     */
    private $duracionHorasLaboradas;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $revisadoPor;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero")
     */
    private $aprobadoPor;

    /**
     * @var integer
     * @ORM\Column(name="kilometraje", type="integer")
     */
    private $kilometraje;

    /**
     * @var boolean
     * @ORM\Column(name="cancelado", type="boolean")
     */
    private $cancelado;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tareasAdicionales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNumero();
    }

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
     * Set numero.
     *
     * @param string $numero
     *
     * @return OrdenTrabajo
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set diagnosticadoPor.
     *
     * @param string $diagnosticadoPor
     *
     * @return OrdenTrabajo
     */
    public function setDiagnosticadoPor($diagnosticadoPor)
    {
        $this->diagnosticadoPor = $diagnosticadoPor;

        return $this;
    }

    /**
     * Get diagnosticadoPor
     *
     * @return string
     */
    public function getDiagnosticadoPor()
    {
        return $this->diagnosticadoPor;
    }

    /**
     * Set prioridad.
     *
     * @param string $prioridad
     *
     * @return OrdenTrabajo
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad.
     *
     * @return string
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Set observaciones.
     *
     * @param string $observaciones
     *
     * @return OrdenTrabajo
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones.
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set estado.
     *
     * @param boolean $estado
     *
     * @return OrdenTrabajo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado.
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaInicio.
     *
     * @param \DateTime $fechaInicio
     *
     * @return OrdenTrabajo
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio.
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal.
     *
     * @param \DateTime $fechaFinal
     *
     * @return OrdenTrabajo
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal.
     *
     * @return \DateTime
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set duracionDias.
     *
     * @param string $duracionDias
     *
     * @return OrdenTrabajo
     */
    public function setDuracionDias($duracionDias)
    {
        $this->duracionDias = $duracionDias;

        return $this;
    }

    /**
     * Get duracionDias.
     *
     * @return string
     */
    public function getDuracionDias()
    {
        return $this->duracionDias;
    }

    /**
     * Set duracionHorasLaboradas.
     *
     * @param string $duracionHorasLaboradas
     *
     * @return OrdenTrabajo
     */
    public function setDuracionHorasLaboradas($duracionHorasLaboradas)
    {
        $this->duracionHorasLaboradas = $duracionHorasLaboradas;

        return $this;
    }

    /**
     * Get duracionHorasLaboradas.
     *
     * @return string
     */
    public function getDuracionHorasLaboradas()
    {
        return $this->duracionHorasLaboradas;
    }

    /**
     * Set realizadaPor.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $realizadaPor
     *
     * @return OrdenTrabajo
     */
    public function setRealizadaPor(\Buseta\BodegaBundle\Entity\Tercero $realizadaPor = null)
    {
        $this->realizadaPor = $realizadaPor;

        return $this;
    }

    /**
     * Get realizadaPor.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getRealizadaPor()
    {
        return $this->realizadaPor;
    }

    /**
     * Set autobus.
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     *
     * @return OrdenTrabajo
     */
    public function setAutobus(\Buseta\BusesBundle\Entity\Autobus $autobus = null)
    {
        $this->autobus = $autobus;

        $this->setKilometraje($autobus->getKilometraje());

        return $this;
    }

    /**
     * Get autobus.
     *
     * @return \Buseta\BusesBundle\Entity\Autobus
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * Set ayudante.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $ayudante
     *
     * @return OrdenTrabajo
     */
    public function setAyudante(\Buseta\BodegaBundle\Entity\Tercero $ayudante = null)
    {
        $this->ayudante = $ayudante;

        return $this;
    }

    /**
     * Get ayudante.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getAyudante()
    {
        return $this->ayudante;
    }

    /**
     * Set requisionMateriales.
     *
     * @param string $requisionMateriales
     *
     * @return OrdenTrabajo
     */
    public function setRequisionMateriales($requisionMateriales)
    {
        $this->requisionMateriales = $requisionMateriales;

        return $this;
    }

    /**
     * Get requisionMateriales.
     *
     * @return \Buseta\BusesBundle\Entity\Autobus
     */
    public function getRequisionMateriales()
    {
        return $this->requisionMateriales;
    }

    /**
     * Add tareasAdicionales.
     *
     * @param \Buseta\TallerBundle\Entity\TareaAdicional $tareasAdicionales
     *
     * @return OrdenTrabajo
     */
    public function addTareasAdicionale(\Buseta\TallerBundle\Entity\TareaAdicional $tareasAdicionales)
    {
        $tareasAdicionales->setOrdenTrabajo($this);

        $this->tareasAdicionales[] = $tareasAdicionales;

        return $this;
    }

    /**
     * Remove tareasAdicionales.
     *
     * @param \Buseta\TallerBundle\Entity\TareaAdicional $tareasAdicionales
     */
    public function removeTareasAdicionale(\Buseta\TallerBundle\Entity\TareaAdicional $tareasAdicionales)
    {
        $tareasAdicionales->setOrdenTrabajo(null);

        $this->tareasAdicionales->removeElement($tareasAdicionales);
    }

    /**
     * Get tareasAdicionales.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTareasAdicionales()
    {
        return $this->tareasAdicionales;
    }

    /**
     * Set revisadoPor.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $revisadoPor
     *
     * @return OrdenTrabajo
     */
    public function setRevisadoPor(\Buseta\BodegaBundle\Entity\Tercero $revisadoPor = null)
    {
        $this->revisadoPor = $revisadoPor;

        return $this;
    }

    /**
     * Get revisadoPor.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getRevisadoPor()
    {
        return $this->revisadoPor;
    }

    /**
     * Set aprobadoPor.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $aprobadoPor
     *
     * @return OrdenTrabajo
     */
    public function setAprobadoPor(\Buseta\BodegaBundle\Entity\Tercero $aprobadoPor = null)
    {
        $this->aprobadoPor = $aprobadoPor;

        return $this;
    }

    /**
     * Get aprobadoPor.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getAprobadoPor()
    {
        return $this->aprobadoPor;
    }

    /**
     * Get kilometraje.
     *
     * @return int
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * Set kilometraje.
     *
     * @param int $kilometraje
     * @return OrdenTrabajo
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;

        return $this;
    }

    /**
     * Set diagnostico
     *
     * @param \Buseta\TallerBundle\Entity\Diagnostico $diagnostico
     * @return OrdenTrabajo
     */
    public function setDiagnostico(\Buseta\TallerBundle\Entity\Diagnostico $diagnostico = null)
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get diagnostico
     *
     * @return \Buseta\TallerBundle\Entity\Diagnostico
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }


    /**
     * Get cancelado.
     *
     * @return boolean
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * Set cancelado
     *
     * @param boolean $cancelado
     * @return OrdenTrabajo
     *
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;

        return $this;
    }
}
