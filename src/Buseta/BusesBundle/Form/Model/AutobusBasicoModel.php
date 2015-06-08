<?php

namespace Buseta\BusesBundle\Form\Model;

use Buseta\BusesBundle\Entity\Autobus;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AutobusBasicoModel.
 */
class AutobusBasicoModel
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
     * @Assert\NotBlank()
     */
    private $numeroChasis;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $numeroMotor;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $pesoTara;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $pesoBruto;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $numeroPlazas;

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
     * @var \DateTime
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $validoHasta;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $fechaRtv1;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $fechaRtv2;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $fechaIngreso;

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
     * @var \Buseta\NomencladorBundle\Entity\MarcaMotor
     */
    private $marcaMotor;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Combustible
     */
    private $combustible;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $archivoAdjunto;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $capacidadTanque;

    /**
     * @var string
     */
    private $rampas;

    /**
     * @var string
     */
    private $barras;

    /**
     * @var string
     */
    private $camaras;

    /**
     * @var string
     */
    private $lectorCedulas;

    /**
     * @var string
     */
    private $publicidad;

    /**
     * @var string
     */
    private $gps;

    /**
     * @var string
     */
    private $wifi;

    /**
     * @var boolean
     */
    private $activo = true;

    /**
     * Constructor
     */
    public function __construct(Autobus $autobus = null)
    {
        $this->archivoAdjunto = new \Doctrine\Common\Collections\ArrayCollection();

        if ($autobus !== null) {
            $this->id = $autobus->getId();

            $this->matricula = $autobus->getMatricula();
            $this->numero = $autobus->getNumero();
            $this->numeroChasis = $autobus->getNumeroChasis();
            $this->numeroCilindros = $autobus->getNumeroCilindros();
            $this->numeroMotor = $autobus->getNumeroMotor();
            $this->numeroPlazas = $autobus->getNumeroPlazas();
            $this->pesoTara = $autobus->getPesoTara();
            $this->pesoBruto = $autobus->getPesoBruto();
            $this->cilindrada = $autobus->getCilindrada();
            $this->potencia = $autobus->getPotencia();
            $this->validoHasta = $autobus->getValidoHasta();
            $this->fechaIngreso = $autobus->getFechaIngreso();
            $this->fechaRtv1 = $autobus->getFechaRtv1();
            $this->fechaRtv2 = $autobus->getFechaRtv2();
            $this->capacidadTanque = $autobus->getCapacidadTanque();
            $this->rampas = $autobus->getRampas();
            $this->barras = $autobus->getBarras();
            $this->wifi = $autobus->getWifi();
            $this->gps = $autobus->getGps();
            $this->camaras = $autobus->getCamaras();
            $this->lectorCedulas = $autobus->getLectorCedulas();
            $this->publicidad = $autobus->getPublicidad();
            $this->activo = $autobus->getActivo();

            if ($autobus->getMarca()) {
                $this->marca  = $autobus->getMarca();
            }
            if ($autobus->getMarcaMotor()) {
                $this->marcaMotor  = $autobus->getMarcaMotor();
            }
            if ($autobus->getModelo()) {
                $this->modelo  = $autobus->getModelo();
            }
            if ($autobus->getEstilo()) {
                $this->estilo  = $autobus->getEstilo();
            }
            if ($autobus->getColor()) {
                $this->color  = $autobus->getColor();
            }
            if ($autobus->getCombustible()) {
                $this->combustible  = $autobus->getCombustible();
            }
            /*if (!$autobus->getArchivoAdjunto()->isEmpty()) {
                $this->archivoAdjunto = $autobus->getArchivoAdjunto();
            } else {
                $this->archivoAdjunto = new ArrayCollection();
            }*/
        }
    }

    /**
     * @return Autobus
     */
    public function getEntityData()
    {
        $autobus = new Autobus();
        $autobus->setMatricula($this->getMatricula());
        $autobus->setNumero($this->getNumero());
        $autobus->setNumeroChasis($this->getNumeroChasis());
        $autobus->setNumeroCilindros($this->getNumeroCilindros());
        $autobus->setNumeroMotor($this->getNumeroMotor());
        $autobus->setNumeroPlazas($this->getNumeroPlazas());
        $autobus->setPesoTara($this->getPesoTara());
        $autobus->setPesoBruto($this->getPesoBruto());
        $autobus->setCilindrada($this->getCilindrada());
        $autobus->setPotencia($this->getPotencia());
        $autobus->setFechaIngreso($this->getFechaIngreso());
        $autobus->setValidoHasta($this->getValidoHasta());
        $autobus->setFechaRtv1($this->getFechaRtv1());
        $autobus->setFechaRtv2($this->getFechaRtv2());
        $autobus->setPesoBruto($this->getPesoBruto());
        $autobus->setCapacidadTanque($this->getCapacidadTanque());
        $autobus->setRampas($this->getRampas());
        $autobus->setBarras($this->getBarras());
        $autobus->setWifi($this->getWifi());
        $autobus->setGps($this->getGps());
        $autobus->setLectorCedulas($this->getLectorCedulas());
        $autobus->setPublicidad($this->getPublicidad());
        $autobus->setActivo($this->getActivo());

        if ($this->getMarca() !== null) {
            $autobus->setMarca($this->getMarca());
        }

        if ($this->getMarcaMotor() !== null) {
            $autobus->setMarcaMotor($this->getMarcaMotor());
        }

        if ($this->getColor() !== null) {
            $autobus->setColor($this->getColor());
        }

        if ($this->getCombustible() !== null) {
            $autobus->setCombustible($this->getCombustible());
        }

        if ($this->getModelo() !== null) {
            $autobus->setModelo($this->getModelo());
        }

        if ($this->getEstilo() !== null) {
            $autobus->setEstilo($this->getEstilo());
        }

        /*if (!$this->getArchivoAdjunto()->isEmpty()) {
            foreach ($this->getArchivoAdjunto() as $archivo) {
                $autobus->addArchivoAdjunto($archivo);
            }
        }*/

        return $autobus;
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
    public function getNumeroChasis()
    {
        return $this->numeroChasis;
    }

    /**
     * @param string $numeroChasis
     */
    public function setNumeroChasis($numeroChasis)
    {
        $this->numeroChasis = $numeroChasis;
    }

    /**
     * @return string
     */
    public function getNumeroMotor()
    {
        return $this->numeroMotor;
    }

    /**
     * @param string $numeroMotor
     */
    public function setNumeroMotor($numeroMotor)
    {
        $this->numeroMotor = $numeroMotor;
    }

    /**
     * @return int
     */
    public function getPesoTara()
    {
        return $this->pesoTara;
    }

    /**
     * @param int $pesoTara
     */
    public function setPesoTara($pesoTara)
    {
        $this->pesoTara = $pesoTara;
    }

    /**
     * @return int
     */
    public function getPesoBruto()
    {
        return $this->pesoBruto;
    }

    /**
     * @param int $pesoBruto
     */
    public function setPesoBruto($pesoBruto)
    {
        $this->pesoBruto = $pesoBruto;
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
     * @return \DateTime
     */
    public function getValidoHasta()
    {
        return $this->validoHasta;
    }

    /**
     * @param \DateTime $validoHasta
     */
    public function setValidoHasta($validoHasta)
    {
        $this->validoHasta = $validoHasta;
    }

    /**
     * @return string
     */
    public function getFechaRtv1()
    {
        return $this->fechaRtv1;
    }

    /**
     * @param string $fechaRtv1
     */
    public function setFechaRtv1($fechaRtv1)
    {
        $this->fechaRtv1 = $fechaRtv1;
    }

    /**
     * @return string
     */
    public function getFechaRtv2()
    {
        return $this->fechaRtv2;
    }

    /**
     * @param string $fechaRtv2
     */
    public function setFechaRtv2($fechaRtv2)
    {
        $this->fechaRtv2 = $fechaRtv2;
    }

    /**
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * @param \DateTime $fechaIngreso
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;
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
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivoAdjunto()
    {
        return $this->archivoAdjunto;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $archivoAdjunto
     */
    public function setArchivoAdjunto($archivoAdjunto)
    {
        $this->archivoAdjunto = $archivoAdjunto;
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
     * @return string
     */
    public function getRampas()
    {
        return $this->rampas;
    }

    /**
     * @param string $rampas
     */
    public function setRampas($rampas)
    {
        $this->rampas = $rampas;
    }

    /**
     * @return string
     */
    public function getBarras()
    {
        return $this->barras;
    }

    /**
     * @param string $barras
     */
    public function setBarras($barras)
    {
        $this->barras = $barras;
    }

    /**
     * @return string
     */
    public function getCamaras()
    {
        return $this->camaras;
    }

    /**
     * @param string $camaras
     */
    public function setCamaras($camaras)
    {
        $this->camaras = $camaras;
    }

    /**
     * @return string
     */
    public function getLectorCedulas()
    {
        return $this->lectorCedulas;
    }

    /**
     * @param string $lectorCedulas
     */
    public function setLectorCedulas($lectorCedulas)
    {
        $this->lectorCedulas = $lectorCedulas;
    }

    /**
     * @return string
     */
    public function getPublicidad()
    {
        return $this->publicidad;
    }

    /**
     * @param string $publicidad
     */
    public function setPublicidad($publicidad)
    {
        $this->publicidad = $publicidad;
    }

    /**
     * @return string
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * @param string $gps
     */
    public function setGps($gps)
    {
        $this->gps = $gps;
    }

    /**
     * @return string
     */
    public function getWifi()
    {
        return $this->wifi;
    }

    /**
     * @param string $wifi
     */
    public function setWifi($wifi)
    {
        $this->wifi = $wifi;
    }

    /**
     * @return boolean
     */
    public function getActivo()
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
