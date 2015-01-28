<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TareaMantenimiento
 *
 * @ORM\Table(name="d_tarea_mantenimiento")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\TareaMantimientoRepository")
 */
class TareaMantenimiento
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
    private $grupos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BusesBundle\Entity\Autobus")
     */
    private $autobus;

    /**
     * @var string
     *
     * @ORM\Column(name="tarea", type="string")
     * @Assert\NotBlank()
     */
    private $tarea;

    /**
     * @var float
     *
     * @ORM\Column(name="kilometraje", type="float", nullable=true)
     * @Assert\NotBlank()
     */
    private $kilometraje;

    /**
     * @var string
     *
     * @ORM\Column(name="horas", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $horas;

    /**
     * @var date
     *
     * @ORM\Column(name="recorrido_inicio", type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $recorrido_inicio;

    /**
     * @var date
     *
     * @ORM\Column(name="ultimo_cumplio", type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $ultimo_cumplio;


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
     * @param string $tarea
     */
    public function setTarea($tarea)
    {
        return $this->tarea = $tarea;
    }

    /**
     * @return string
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set kilometraje
     *
     * @param float $kilometraje
     * @return TareaMantenimiento
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;
    
        return $this;
    }

    /**
     * Get kilometraje
     *
     * @return float 
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * Set horas
     *
     * @param string $horas
     * @return TareaMantenimiento
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;
    
        return $this;
    }

    /**
     * Get horas
     *
     * @return string 
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * Set grupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupos
     * @return TareaMantenimiento
     */
    public function setGrupos(\Buseta\NomencladorBundle\Entity\Grupo $grupos = null)
    {
        $this->grupos = $grupos;
    
        return $this;
    }

    /**
     * Get grupos
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Set subgrupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos
     * @return TareaMantenimiento
     */
    public function setSubgrupos(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos = null)
    {
        $this->subgrupos = $subgrupos;
    
        return $this;
    }

    /**
     * Get subgrupos
     *
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo 
     */
    public function getSubgrupos()
    {
        return $this->subgrupos;
    }

    /**
     * Set autobus
     *
     * @param \Buseta\BusesBundle\Entity\Autobus $autobus
     * @return TareaMantenimiento
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
     * Set recorrido_inicio
     *
     * @param \DateTime $recorridoInicio
     * @return TareaMantenimiento
     */
    public function setRecorridoInicio($recorridoInicio)
    {
        $this->recorrido_inicio = $recorridoInicio;
    
        return $this;
    }

    /**
     * Get recorrido_inicio
     *
     * @return \DateTime 
     */
    public function getRecorridoInicio()
    {
        return $this->recorrido_inicio;
    }

    /**
     * Set ultimo_cumplio
     *
     * @param \DateTime $ultimoCumplio
     * @return TareaMantenimiento
     */
    public function setUltimoCumplio($ultimoCumplio)
    {
        $this->ultimo_cumplio = $ultimoCumplio;
    
        return $this;
    }

    /**
     * Get ultimo_cumplio
     *
     * @return \DateTime 
     */
    public function getUltimoCumplio()
    {
        return $this->ultimo_cumplio;
    }
}