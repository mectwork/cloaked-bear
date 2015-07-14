<?php
namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class BaseVehiculo
 * @UniqueEntity(fields={"matricula"})
 */
abstract class BaseVehiculo
{
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="matricula", type="string", length=32)
     * @Assert\NotBlank(groups={"web", "console", "Autobus"})
     */
    protected $matricula;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=32)
     */
    protected $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="marcaCajacambio", type="string", nullable=true)
     */
    protected $marcaCajacambio;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoCajacambio", type="string", nullable=true)
     */
    protected $tipoCajacambio;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Marca")
     */
    protected $marca;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Modelo")
     */
    protected $modelo;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Estilo")
     */
    protected $estilo;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Color")
     */
    protected $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroPlazas", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    protected $numeroPlazas;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\MarcaMotor")
     */
    protected $marcaMotor;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Combustible")
     */
    protected $combustible;

    /**
     * @var integer
     *
     * @ORM\Column(name="anno", type="integer", nullable=true)
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    protected $anno;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacidadTanque", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "Autobus"})
     */
    protected $capacidadTanque;

    /**
     * @var integer
     *
     * @ORM\Column(name="potencia", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "BaseVehiculo"})
     */
    protected $potencia;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroCilindros", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "BaseVehiculo"})
     */
    protected $numeroCilindros;

    /**
     * @var integer
     *
     * @ORM\Column(name="cilindrada", type="integer")
     * @Assert\Type("integer", groups={"web", "console", "BaseVehiculo"})
     */
    protected $cilindrada;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    protected $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="kilometraje", type="integer", nullable=true)
     */
    protected $kilometraje;

    /**
     * @var integer
     *
     * @ORM\Column(name="horas", type="integer", nullable=true)
     */
    protected $horas;

    /**
     * Set matricula.
     *
     * @param string $matricula
     *
     * @return BaseVehiculo
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula.
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
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
     * Set marcaCajacambio.
     *
     * @param string $marcaCajacambio
     *
     * @return BaseVehiculo
     */
    public function setMarcaCajacambio($marcaCajacambio)
    {
        $this->marcaCajacambio = $marcaCajacambio;

        return $this;
    }

    /**
     * Get marcaCajacambio.
     *
     * @return string
     */
    public function getMarcaCajacambio()
    {
        return $this->marcaCajacambio;
    }

    /**
     * Set tipoCajacambio.
     *
     * @param string $tipoCajacambio
     *
     * @return BaseVehiculo
     */
    public function setTipoCajacambio($tipoCajacambio)
    {
        $this->tipoCajacambio = $tipoCajacambio;

        return $this;
    }

    /**
     * Get tipoCajacambio.
     *
     * @return string
     */
    public function getTipoCajacambio()
    {
        return $this->tipoCajacambio;
    }

    /**
     * Set numeroPlazas.
     *
     * @param integer $numeroPlazas
     *
     * @return BaseVehiculo
     */
    public function setNumeroPlazas($numeroPlazas)
    {
        $this->numeroPlazas = $numeroPlazas;

        return $this;
    }

    /**
     * Get numeroPlazas.
     *
     * @return integer
     */
    public function getNumeroPlazas()
    {
        return $this->numeroPlazas;
    }

    /**
     * Set anno.
     *
     * @param integer $anno
     *
     * @return BaseVehiculo
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;

        return $this;
    }

    /**
     * Get anno.
     *
     * @return integer
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * Set capacidadTanque.
     *
     * @param integer $capacidadTanque
     *
     * @return BaseVehiculo
     */
    public function setCapacidadTanque($capacidadTanque)
    {
        $this->capacidadTanque = $capacidadTanque;

        return $this;
    }

    /**
     * Get capacidadTanque.
     *
     * @return integer
     */
    public function getCapacidadTanque()
    {
        return $this->capacidadTanque;
    }

    /**
     * Set numeroCilindros.
     *
     * @param integer $numeroCilindros
     *
     * @return BaseVehiculo
     */
    public function setNumeroCilindros($numeroCilindros)
    {
        $this->numeroCilindros = $numeroCilindros;

        return $this;
    }

    /**
     * Get numeroCilindros.
     *
     * @return integer
     */
    public function getNumeroCilindros()
    {
        return $this->numeroCilindros;
    }

    /**
     * Set cilindrada.
     *
     * @param integer $cilindrada
     *
     * @return BaseVehiculo
     */
    public function setCilindrada($cilindrada)
    {
        $this->cilindrada = $cilindrada;

        return $this;
    }

    /**
     * Get cilindrada.
     *
     * @return integer
     */
    public function getCilindrada()
    {
        return $this->cilindrada;
    }

    /**
     * Set potencia.
     *
     * @param integer $potencia
     *
     * @return BaseVehiculo
     */
    public function setPotencia($potencia)
    {
        $this->potencia = $potencia;

        return $this;
    }

    /**
     * Get potencia.
     *
     * @return integer
     */
    public function getPotencia()
    {
        return $this->potencia;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param mixed $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
    }

    /**
     * @return mixed
     */
    public function getEstilo()
    {
        return $this->estilo;
    }

    /**
     * @param mixed $estilo
     */
    public function setEstilo($estilo)
    {
        $this->estilo = $estilo;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getMarcaMotor()
    {
        return $this->marcaMotor;
    }

    /**
     * @param mixed $marcaMotor
     */
    public function setMarcaMotor($marcaMotor)
    {
        $this->marcaMotor = $marcaMotor;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Set kilometraje.
     *
     * @param integer $kilometraje
     *
     * @return BaseVehiculo
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;

        return $this;
    }

    /**
     * Get kilometraje.
     *
     * @return integer
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * Set horas.
     *
     * @param integer $horas
     *
     * @return BaseVehiculo
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get horas.
     *
     * @return integer
     */
    public function getHoras()
    {
        return $this->horas;
    }


    public function __toString()
    {
        return sprintf('%d (%s)', $this->numero, $this->matricula);
    }
}
