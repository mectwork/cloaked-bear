<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FiltroModel.
 */
class FiltroModel
{
    /**
     * @var \Buseta\BusesBundle\Entity\FiltroCaja
     * @Assert\NotBlank()
     */
    private $filtroCaja;

    /**
     * @var \Buseta\BusesBundle\Entity\FiltroAgua
     * @Assert\NotBlank()
     */
    private $filtroAgua;

    /**
     * @var \Buseta\BusesBundle\Entity\FiltroAceite
     * @Assert\NotBlank()
     */
    private $filtroAceite;

    /**
     * @var \Buseta\BusesBundle\Entity\FiltroHidraulico
     * @Assert\NotBlank()
     */
    private $filtroHidraulico;

    /**
     * @var \Buseta\BusesBundle\Entity\FiltroDiesel
     * @Assert\NotBlank()
     */
    private $filtroDiesel;

    /**
     * @var \Buseta\BusesBundle\Entity\FiltroTransmision
     * @Assert\NotBlank()
     */
    private $filtroTransmision;


    function __construct(Autobus $autobus)
    {
        if($autobus->getId() != null)
        {
            $this->id = $autobus->getId();

            if ($autobus->getFiltroCaja() != null) {
                $this->filtroCaja = $autobus->getFiltroCaja();
            }
            if ($autobus->getFiltroAgua() != null) {
                $this->filtroAgua = $autobus->getFiltroAgua();
            }
            if ($autobus->getFiltroAceite() != null) {
                $this->filtroAceite = $autobus->getFiltroAceite();
            }
            if ($autobus->getFiltroHidraulico() != null) {
                $this->filtroHidraulico = $autobus->getFiltroHidraulico();
            }
            if ($autobus->getFiltroTransmision() != null) {
                $this->filtroTransmision = $autobus->getFiltroTransmision();
            }
            if ($autobus->getFiltroDiesel() != null) {
                $this->filtroDiesel = $autobus->getFiltroDiesel();
            }
        }
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
     * @return \Buseta\BusesBundle\Entity\FiltroCaja
     */
    public function getFiltroCaja()
    {
        return $this->filtroCaja;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\FiltroCaja $filtroCaja
     */
    public function setFiltroCaja($filtroCaja)
    {
        $this->filtroCaja = $filtroCaja;
    }

    /**
     * @return \Buseta\BusesBundle\Entity\FiltroAgua
     */
    public function getFiltroAgua()
    {
        return $this->filtroAgua;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\FiltroAgua $filtroAgua
     */
    public function setFiltroAgua($filtroAgua)
    {
        $this->filtroAgua = $filtroAgua;
    }

    /**
     * @return \Buseta\BusesBundle\Entity\FiltroAceite
     */
    public function getFiltroAceite()
    {
        return $this->filtroAceite;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\FiltroAceite $filtroAceite
     */
    public function setFiltroAceite($filtroAceite)
    {
        $this->filtroAceite = $filtroAceite;
    }

    /**
     * @return \Buseta\BusesBundle\Entity\FiltroHidraulico
     */
    public function getFiltroHidraulico()
    {
        return $this->filtroHidraulico;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\FiltroHidraulico $filtroHidraulico
     */
    public function setFiltroHidraulico($filtroHidraulico)
    {
        $this->filtroHidraulico = $filtroHidraulico;
    }

    /**
     * @return \Buseta\BusesBundle\Entity\FiltroDiesel
     */
    public function getFiltroDiesel()
    {
        return $this->filtroDiesel;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\FiltroDiesel $filtroDiesel
     */
    public function setFiltroDiesel($filtroDiesel)
    {
        $this->filtroDiesel = $filtroDiesel;
    }

    /**
     * @return \Buseta\BusesBundle\Entity\FiltroTransmision
     */
    public function getFiltroTransmision()
    {
        return $this->filtroTransmision;
    }

    /**
     * @param \Buseta\BusesBundle\Entity\FiltroTransmision $filtroTransmision
     */
    public function setFiltroTransmision($filtroTransmision)
    {
        $this->filtroTransmision = $filtroTransmision;
    }


}
