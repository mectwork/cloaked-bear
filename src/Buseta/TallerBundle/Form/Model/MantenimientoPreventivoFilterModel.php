<?php

namespace Buseta\TallerBundle\Form\Model;

class MantenimientoPreventivoFilterModel
{
    /**
     * @var string
     */
    private $grupo;

    /**
     * @var string
     */
    private $subgrupo;

    /**
     * @var string
     */
    private $tarea;

    /**
     * @var string
     */
    private $autobus;

    /**
     * Set grupo.
     *
     * @param string $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * Get grupo.
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set subgrupo.
     *
     * @param string $subgrupo
     */
    public function setSubgrupo($subgrupo)
    {
        $this->subgrupo = $subgrupo;
    }

    /**
     * Get subgrupo.
     *
     * @return string
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * Set tarea.
     *
     * @param string $tarea
     */
    public function setTarea($tarea)
    {
        $this->tarea = $tarea;
    }

    /**
     * Get tarea.
     *
     * @return string
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set autobus.
     *
     * @param string $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * Get autobus.
     *
     * @return string
     */
    public function getAutobus()
    {
        return $this->autobus;
    }
}
