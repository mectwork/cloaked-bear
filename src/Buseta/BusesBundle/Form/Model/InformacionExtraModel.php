<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InformacionExtraModel.
 */
class InformacionExtraModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $numeroUnidad;

    /**
     * @var string
     */
    private $valorUnidad;

    /**
     * @var string
     */
    private $anno;

    /**
     * @var string
     */
    private $marcaCajacambio;

    /**
     * @var string
     */
    private $tipoCajacambio;

    /**
     * @var string
     */
    private $carterCapacidadlitros;

    /**
     * @var \Buseta\NomencladorBundle\Entity\AceiteCajaCambios
     */
    private $aceitecajacambios;

    /**
     * @var \Buseta\NomencladorBundle\Entity\AceiteTransmision
     */
    private $aceitetransmision;

    /**
     * @var \Buseta\NomencladorBundle\Entity\AceiteHidraulico
     */
    private $aceitehidraulico;

    /**
     * @var \Buseta\NomencladorBundle\Entity\AceiteMotor
     */
    private $aceitemotor;

    /**
     * @var string
     */
    private $bateria1;

    /**
     * @var string
     */
    private $bateria2;

    function __construct(Autobus $autobus)
    {
        if($autobus->getId() != null)
        {
            $this->id = $autobus->getId();
            $this->aceitecajacambios = $autobus->getAceitecajacambios();
            $this->aceitehidraulico = $autobus->getAceitehidraulico();
            $this->aceitemotor = $autobus->getAceitemotor();
            $this->aceitetransmision = $autobus->getAceitetransmision();
            $this->bateria1 = $autobus->getBateria1();
            $this->bateria2 = $autobus->getBateria2();
            $this->numeroUnidad = $autobus->getNumeroUnidad();
            $this->valorUnidad = $autobus->getValorUnidad();
            $this->carterCapacidadlitros = $autobus->getCarterCapacidadlitros();
            $this->tipoCajacambio = $autobus->getTipoCajacambio();
            $this->marcaCajacambio = $autobus->getMarcaCajacambio();
            $this->anno = $autobus->getAnno();
        }
    }

    /**
     * @return string
     */
    public function getNumeroUnidad()
    {
        return $this->numeroUnidad;
    }

    /**
     * @param string $numeroUnidad
     */
    public function setNumeroUnidad($numeroUnidad)
    {
        $this->numeroUnidad = $numeroUnidad;
    }

    /**
     * @return string
     */
    public function getValorUnidad()
    {
        return $this->valorUnidad;
    }

    /**
     * @param string $valorUnidad
     */
    public function setValorUnidad($valorUnidad)
    {
        $this->valorUnidad = $valorUnidad;
    }

    /**
     * @return string
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * @param string $anno
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;
    }

    /**
     * @return string
     */
    public function getMarcaCajacambio()
    {
        return $this->marcaCajacambio;
    }

    /**
     * @param string $marcaCajacambio
     */
    public function setMarcaCajacambio($marcaCajacambio)
    {
        $this->marcaCajacambio = $marcaCajacambio;
    }

    /**
     * @return string
     */
    public function getTipoCajacambio()
    {
        return $this->tipoCajacambio;
    }

    /**
     * @param string $tipoCajacambio
     */
    public function setTipoCajacambio($tipoCajacambio)
    {
        $this->tipoCajacambio = $tipoCajacambio;
    }

    /**
     * @return string
     */
    public function getCarterCapacidadlitros()
    {
        return $this->carterCapacidadlitros;
    }

    /**
     * @param string $carterCapacidadlitros
     */
    public function setCarterCapacidadlitros($carterCapacidadlitros)
    {
        $this->carterCapacidadlitros = $carterCapacidadlitros;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\AceiteCajaCambios
     */
    public function getAceitecajacambios()
    {
        return $this->aceitecajacambios;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\AceiteCajaCambios $aceitecajacambios
     */
    public function setAceitecajacambios($aceitecajacambios)
    {
        $this->aceitecajacambios = $aceitecajacambios;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\AceiteTransmision
     */
    public function getAceitetransmision()
    {
        return $this->aceitetransmision;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\AceiteTransmision $aceitetransmision
     */
    public function setAceitetransmision($aceitetransmision)
    {
        $this->aceitetransmision = $aceitetransmision;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\AceiteHidraulico
     */
    public function getAceitehidraulico()
    {
        return $this->aceitehidraulico;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\AceiteHidraulico $aceitehidraulico
     */
    public function setAceitehidraulico($aceitehidraulico)
    {
        $this->aceitehidraulico = $aceitehidraulico;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\AceiteMotor
     */
    public function getAceitemotor()
    {
        return $this->aceitemotor;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\AceiteMotor $aceitemotor
     */
    public function setAceitemotor($aceitemotor)
    {
        $this->aceitemotor = $aceitemotor;
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
     * @return string
     */
    public function getBateria1()
    {
        return $this->bateria1;
    }

    /**
     * @param string $bateria1
     */
    public function setBateria1($bateria1)
    {
        $this->bateria1 = $bateria1;
    }

    /**
     * @return string
     */
    public function getBateria2()
    {
        return $this->bateria2;
    }

    /**
     * @param string $bateria2
     */
    public function setBateria2($bateria2)
    {
        $this->bateria2 = $bateria2;
    }


}
