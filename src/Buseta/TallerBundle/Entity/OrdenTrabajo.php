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
     * @var string
     *
     * @ORM\Column(name="realizada_por", type="string", nullable=false)
     */
    private $realizada_por;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\TareaAdicional", mappedBy="orden_trabajo", cascade={"all"})
     */
    private $tarea_adicional;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tarea_adicional = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set realizada_por
     *
     * @param string $realizadaPor
     * @return OrdenTrabajo
     */
    public function setRealizadaPor($realizadaPor)
    {
        $this->realizada_por = $realizadaPor;
    
        return $this;
    }

    /**
     * Get realizada_por
     *
     * @return string 
     */
    public function getRealizadaPor()
    {
        return $this->realizada_por;
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