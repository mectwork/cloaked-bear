<?php
/**
 * Created by PhpStorm.
 * User: luis
 * Date: 13/03/15
 * Time: 1:20
 */

namespace Buseta\TallerBundle\Form\Model;


class HistoricoMantenimientosFilterModel
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
     * @var string
     */
    private $kilometraje;

    /**
     * @var string
     */
    private $fechaInicio;

    /**
     * @var string
     */
    private $fechaFinal;

    /**
     * Set grupo
     *
     * @param string $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * Get grupo
     *
     * @return string
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set subgrupo
     *
     * @param string $subgrupo
     */
    public function setSubgrupo($subgrupo)
    {
        $this->subgrupo = $subgrupo;
    }

    /**
     * Get subgrupo
     *
     * @return string
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * Set tarea
     *
     * @param string $tarea
     */
    public function setTarea($tarea)
    {
        $this->tarea = $tarea;
    }

    /**
     * Get tarea
     *
     * @return string
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set autobus
     *
     * @param string $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * Get autobus
     *
     * @return string
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * Get kilometraje
     *
     * @return string
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * Set kilometraje
     *
     * @param string $kilometraje
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;
    }

    /**
     * Get fechaFinal
     *
     * @return string
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set fechaFinal
     *
     * @param string $fechaFinal
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;
    }

    /**
     * Get fechaInicio
     *
     * @return string
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaInicio
     *
     * @param string $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }
}