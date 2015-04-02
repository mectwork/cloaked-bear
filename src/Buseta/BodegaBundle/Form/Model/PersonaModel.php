<?php

namespace Buseta\BodegaBundle\Form\Model;


use Buseta\BodegaBundle\Entity\Persona;
use Pagerfanta\Tests\Adapter\DoctrineORM\Person;

class PersonaModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * Constructor.
     *
     * @param Persona $persona
     */
    function __construct(Persona $persona = null)
    {
        if ($persona !== null) {
            $this->activo   = true;
            $this->tercero  = $persona->getTercero();
            $this->id       = $persona->getId();
        }
    }

    /**
     * Get entity data
     *
     * @return Persona
     */
    public function getEntityData()
    {
        $persona = new Persona();
        $persona->setTercero($this->getTercero());

        return $persona;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }

    /**
     * @return boolean
     */
    public function isActivo()
    {
        return $this->activo;
    }

    /**
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }
}
