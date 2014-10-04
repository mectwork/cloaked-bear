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
}