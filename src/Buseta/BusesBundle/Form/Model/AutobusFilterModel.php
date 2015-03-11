<?php
namespace Buseta\BusesBundle\Form\Model;

class AutobusFilterModel
{
    /**
     * @var string
     */
    private $matricula;

    /**
     * @var string
     */
    private $numero;

    /**
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * @param string $matricula
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }
} 