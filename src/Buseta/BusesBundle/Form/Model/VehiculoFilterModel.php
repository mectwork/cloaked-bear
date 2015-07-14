<?php
namespace Buseta\BusesBundle\Form\Model;

class VehiculoFilterModel
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
     * @var \Buseta\NomencladorBundle\Entity\Marca
     */
    private $marca;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Estilo
     */
    private $estilo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Color
     */
    private $color;

    /**
     * @var \Buseta\NomencladorBundle\Entity\MarcaMotor
     */
    private $marcaMotor;

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

    /**
     * @return \Buseta\NomencladorBundle\Entity\Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Marca $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Color $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Estilo
     */
    public function getEstilo()
    {
        return $this->estilo;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Estilo $estilo
     */
    public function setEstilo($estilo)
    {
        $this->estilo = $estilo;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\MarcaMotor
     */
    public function getMarcaMotor()
    {
        return $this->marcaMotor;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\MarcaMotor $marcaMotor
     */
    public function setMarcaMotor($marcaMotor)
    {
        $this->marcaMotor = $marcaMotor;
    }
} 