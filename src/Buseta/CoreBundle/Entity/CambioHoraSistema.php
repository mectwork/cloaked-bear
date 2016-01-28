<?php

namespace Buseta\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CambioHoraSistema
 *
 * @ORM\Table(name="conf_cambio_hora")
 * @ORM\Entity
 */
class CambioHoraSistema
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
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="time", nullable=true)
     * @Assert\NotBlank()
     */
    private $hora;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;


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
     * Set hora
     *
     * @param \DateTime $hora
     * @return CambioHoraSistema
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return CambioHoraSistema
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }
}
