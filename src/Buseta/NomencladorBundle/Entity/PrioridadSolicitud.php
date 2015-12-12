<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PrioridadSolicitud
 *
 * @ORM\Table(name="n_prioridad_solicitud")
 * @ORM\Entity
 */
class PrioridadSolicitud extends BaseNomenclador
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
     * @var \Buseta\NomencladorBundle\Entity\TiempoPrioridad
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\TiempoPrioridad")
     * @ORM\JoinColumn(name="tiempo_prioridad_id",referencedColumnName="id")
     * @Assert\NotNull()
     */
    private $tiempoPrioridad;


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
     * Set tiempoPrioridad
     *
     * @param \Buseta\NomencladorBundle\Entity\TiempoPrioridad  $tiempoPrioridad
     * @return PrioridadSolicitud
     */
    public function setTiempoPrioridad(\Buseta\NomencladorBundle\Entity\TiempoPrioridad  $tiempoPrioridad  = null)
    {
        $this->tiempoPrioridad = $tiempoPrioridad;
        return $this;
    }

    /**
     * Get tiempoPrioridad
     *
     * @return \Buseta\NomencladorBundle\Entity\TiempoPrioridad
     */
    public function getTiempoPrioridad ()
    {
        return $this->tiempoPrioridad;
    }


}
