<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Vehiculo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VehiculoModel.
 */
class VehiculoModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $matricula;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $numero;

    /**
     * @var string
     */
    private $marcaCajacambio;

    /**
     * @var string
     */
    private $tipoCajacambio;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Marca
     */
    private $marca;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Modelo
     */
    private $modelo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Estilo
     */
    private $estilo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Color
     */
    private $color;
    
    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $numeroPlazas;

    /**
     * @var \Buseta\NomencladorBundle\Entity\MarcaMotor
     */
    private $marcaMotor;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Combustible
     */
    private $combustible;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $capacidadTanque;

    /**
     * @var integer
     */
    private $anno;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $numeroCilindros;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $cilindrada;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $potencia;

    /**
     * @var integer
     */
    private $kilometraje;

    /**
     * @var integer
     */
    private $horas;

    /**
     * @var boolean
     */
    private $activo = true;

    /**
     * Constructor
     */
    public function __construct(Vehiculo $vehiculo = null)
    {

        if ($vehiculo !== null) {
            $this->id = $vehiculo->getId();
            $this->matricula = $vehiculo->getMatricula();
            $this->numero = $vehiculo->getNumero();
            $this->marcaCajacambio = $vehiculo->getMarcaCajacambio();
            $this->tipoCajacambio = $vehiculo->getTipoCajacambio();
            $this->numeroPlazas = $vehiculo->getNumeroPlazas();
            $this->anno = $vehiculo->getAnno();
            $this->capacidadTanque = $vehiculo->getCapacidadTanque();
            $this->potencia = $vehiculo->getPotencia();
            $this->numeroCilindros = $vehiculo->getNumeroCilindros();
            $this->cilindrada = $vehiculo->getCilindrada();
            $this->kilometraje = $vehiculo->getKilometraje();
            $this->horas = $vehiculo->getHoras();
            $this->activo = $vehiculo->getActivo();

            if ($vehiculo->getMarca()) {
                $this->marca  = $vehiculo->getMarca();
            }
            if ($vehiculo->getModelo()) {
                $this->modelo  = $vehiculo->getModelo();
            }
            if ($vehiculo->getEstilo()) {
                $this->estilo  = $vehiculo->getEstilo();
            }
            if ($vehiculo->getColor()) {
                $this->color  = $vehiculo->getColor();
            }
            if ($vehiculo->getMarcaMotor()) {
                $this->marcaMotor  = $vehiculo->getMarcaMotor();
            }
            if ($vehiculo->getCombustible()) {
                $this->combustible  = $vehiculo->getCombustible();
            }
            
        }
    }

    /**
     * @return Vehiculo
     */
    public function getEntityData()
    {
        $vehiculo = new Vehiculo();
        $vehiculo->setMatricula($this->getMatricula());
        $vehiculo->setNumero($this->getNumero());
        $vehiculo->setMarcaCajacambio($this->getMarcaCajacambio());
        $vehiculo->setTipoCajacambio($this->getTipoCajacambio());
        $vehiculo->setNumeroPlazas($this->getNumeroPlazas());
        $vehiculo->setNumeroCilindros($this->getNumeroCilindros());
        $vehiculo->setCilindrada($this->getCilindrada());
        $vehiculo->setPotencia($this->getPotencia());
        $vehiculo->setCapacidadTanque($this->getCapacidadTanque());
        $vehiculo->setKilometraje($this->getKilometraje());
        $vehiculo->setHoras($this->getHoras());
        $vehiculo->setAnno($this->getAnno());
        $vehiculo->setActivo($this->isActivo());

        if ($this->getMarca() !== null) {
            $vehiculo->setMarca($this->getMarca());
        }
        if ($this->getModelo() !== null) {
            $vehiculo->setModelo($this->getModelo());
        }
        if ($this->getEstilo() !== null) {
            $vehiculo->setEstilo($this->getEstilo());
        }
        if ($this->getColor() !== null) {
            $vehiculo->setColor($this->getColor());
        }
        if ($this->getMarcaMotor() !== null) {
            $vehiculo->setMarcaMotor($this->getMarcaMotor());
        }
        if ($this->getCombustible() !== null) {
            $vehiculo->setCombustible($this->getCombustible());
        }

        return $vehiculo;
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
     * @return \Buseta\NomencladorBundle\Entity\Modelo
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Modelo $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
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
     * @return int
     */
    public function getNumeroPlazas()
    {
        return $this->numeroPlazas;
    }

    /**
     * @param int $numeroPlazas
     */
    public function setNumeroPlazas($numeroPlazas)
    {
        $this->numeroPlazas = $numeroPlazas;
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

    /**
     * @return \Buseta\NomencladorBundle\Entity\Combustible
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Combustible $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
    }

    /**
     * @return int
     */
    public function getCapacidadTanque()
    {
        return $this->capacidadTanque;
    }

    /**
     * @param int $capacidadTanque
     */
    public function setCapacidadTanque($capacidadTanque)
    {
        $this->capacidadTanque = $capacidadTanque;
    }

    /**
     * @return int
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * @param int $anno
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;
    }

    /**
     * @return int
     */
    public function getNumeroCilindros()
    {
        return $this->numeroCilindros;
    }

    /**
     * @param int $numeroCilindros
     */
    public function setNumeroCilindros($numeroCilindros)
    {
        $this->numeroCilindros = $numeroCilindros;
    }

    /**
     * @return int
     */
    public function getCilindrada()
    {
        return $this->cilindrada;
    }

    /**
     * @param int $cilindrada
     */
    public function setCilindrada($cilindrada)
    {
        $this->cilindrada = $cilindrada;
    }

    /**
     * @return int
     */
    public function getPotencia()
    {
        return $this->potencia;
    }

    /**
     * @param int $potencia
     */
    public function setPotencia($potencia)
    {
        $this->potencia = $potencia;
    }

    /**
     * @return int
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * @param int $kilometraje
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;
    }

    /**
     * @return int
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * @param int $horas
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;
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
