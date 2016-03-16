<?php

namespace Buseta\CombustibleBundle\Event;

use Buseta\CombustibleBundle\Entity\ConfiguracionCombustible;
use Buseta\CombustibleBundle\Entity\ConfiguracionMarchamo;
use Buseta\CombustibleBundle\Entity\ServicioCombustible;
use Symfony\Component\EventDispatcher\Event;


/**
 * Class FilterServicioCombustibleEvent
 *
 * @package Buseta\CombustibleBundle\Event
 */
class FilterServicioCombustibleEvent extends Event
{
    /**
     * @var ServicioCombustible
     */
    private $servicioCombustible;

    /**
     * @var ConfiguracionCombustible
     */
    private $confCombustible;

    /**
     * @var ConfiguracionMarchamo
     */
    private $confMarchamo;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @var boolean
     */
    private $flush;

    /**
     * FilterAlbaranEvent constructor
     *
     * @param ServicioCombustible $servicioCombustible
     * @param ConfiguracionCombustible $confCombustible
     * @param ConfiguracionMarchamo $confMarchamo
     * @param boolean $flush
     */
    function __construct(
        ServicioCombustible $servicioCombustible,
        ConfiguracionCombustible $confCombustible,
        ConfiguracionMarchamo $confMarchamo,
        $flush=true
    ) {
        $this->servicioCombustible = $servicioCombustible;
        $this->confCombustible = $confCombustible;
        $this->confMarchamo = $confMarchamo;
        $this->error = false;
        $this->flush = $flush;
    }

    /**
     * @return ServicioCombustible
     */
    public function getServicioCombustible()
    {
        return $this->servicioCombustible;
    }

    /**
     * @param ServicioCombustible $servicioCombustible
     */
    public function setServicioCombustible($servicioCombustible)
    {
        $this->servicioCombustible = $servicioCombustible;
    }

    /**
     * @return ConfiguracionCombustible
     */
    public function getConfCombustible()
    {
        return $this->confCombustible;
    }

    /**
     * @param ConfiguracionCombustible $confCombustible
     */
    public function setConfCombustible($confCombustible)
    {
        $this->confCombustible = $confCombustible;
    }

    /**
     * @return ConfiguracionMarchamo
     */
    public function getConfMarchamo()
    {
        return $this->confMarchamo;
    }

    /**
     * @param ConfiguracionMarchamo $confMarchamo
     */
    public function setConfMarchamo($confMarchamo)
    {
        $this->confMarchamo = $confMarchamo;
    }

    /**
     * @return null|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param null|string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return boolean
     */
    public function isFlush()
    {
        return $this->flush;
    }
}
