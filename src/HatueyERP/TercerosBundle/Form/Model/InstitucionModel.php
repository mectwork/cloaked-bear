<?php

namespace HatueyERP\TercerosBundle\Form\Model;


use HatueyERP\TercerosBundle\Entity\Institucion;

class InstitucionModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $isInstitucion;

    /**
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     */
    private $tercero;


    /**
     * @param Institucion $institucion
     */
    function __construct(Institucion $institucion = null)
    {
        if ($institucion) {
            $this->id = $institucion->getId();
            $this->isInstitucion = true;
            if ($institucion->getTercero()) {
                $this->tercero = $institucion->getTercero();
            }
        }
    }

    /**
     * @return Institucion
     */
    public function getEntityData()
    {
        $cliente = new Institucion();
        $cliente->setTercero($this->getTercero());

        return $cliente;
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
     * @return boolean
     */
    public function isIsInstitucion()
    {
        return $this->isInstitucion;
    }

    /**
     * @param boolean $isInstitucion
     */
    public function setIsInstitucion($isInstitucion)
    {
        $this->isInstitucion = $isInstitucion;
    }

    /**
     * @return \HatueyERP\TercerosBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }
}