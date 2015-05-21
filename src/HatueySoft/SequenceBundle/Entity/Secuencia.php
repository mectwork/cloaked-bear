<?php

namespace HatueySoft\SequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Secuencia.
 *
 * @ORM\Table(name="d_secuencia")
 * @ORM\Entity(repositoryClass="HatueySoft\SequenceBundle\Entity\Repository\SecuenciaRepository")
 */
class Secuencia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", nullable=true)
     * @Assert\Choice(choices={"incremental", "fija"})
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="prefijo", type="string", nullable=true)
     * @Assert\NotBlank
     */
    private $prefijo;

    /**
     * @var string
     *
     * @ORM\Column(name="sufijo", type="string", nullable=true)
     * @Assert\NotBlank
     */
    private $sufijo;

    /**
     * @var string
     *
     * @ORM\Column(name="siguienteValor", type="string", nullable=true)
     */
    private $siguienteValor;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadIncrementar", type="integer", nullable=true)
     */
    private $cantidadIncrementar;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadRelleno", type="integer", nullable=true)
     */
    private $cantidadRelleno;

    /**
     * @var string
     *
     * @ORM\Column(name="relleno", type="string", nullable=true)
     */
    private $relleno;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", nullable=true)
     */
    private $codigo;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Secuencia
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Secuencia
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set prefijo
     *
     * @param string $prefijo
     * @return Secuencia
     */
    public function setPrefijo($prefijo)
    {
        $this->prefijo = $prefijo;
    
        return $this;
    }

    /**
     * Get prefijo
     *
     * @return string 
     */
    public function getPrefijo()
    {
        return $this->prefijo;
    }

    /**
     * Set sufijo
     *
     * @param string $sufijo
     * @return Secuencia
     */
    public function setSufijo($sufijo)
    {
        $this->sufijo = $sufijo;
    
        return $this;
    }

    /**
     * Get sufijo
     *
     * @return string 
     */
    public function getSufijo()
    {
        return $this->sufijo;
    }

    /**
     * Set siguienteValor
     *
     * @param string $siguienteValor
     * @return Secuencia
     */
    public function setSiguienteValor($siguienteValor)
    {
        $this->siguienteValor = $siguienteValor;
    
        return $this;
    }

    /**
     * Get siguienteValor
     *
     * @return string 
     */
    public function getSiguienteValor()
    {
        return $this->siguienteValor;
    }

    /**
     * Set cantidadIncrementar
     *
     * @param integer $cantidadIncrementar
     * @return Secuencia
     */
    public function setCantidadIncrementar($cantidadIncrementar)
    {
        $this->cantidadIncrementar = $cantidadIncrementar;
    
        return $this;
    }

    /**
     * Get cantidadIncrementar
     *
     * @return integer 
     */
    public function getCantidadIncrementar()
    {
        return $this->cantidadIncrementar;
    }

    /**
     * Set relleno
     *
     * @param string $relleno
     * @return Secuencia
     */
    public function setRelleno($relleno)
    {
        $this->relleno = $relleno;
    
        return $this;
    }

    /**
     * Get relleno
     *
     * @return string 
     */
    public function getRelleno()
    {
        return $this->relleno;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Secuencia
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @return int
     */
    public function getCantidadRelleno()
    {
        return $this->cantidadRelleno;
    }

    /**
     * @param int $cantidadRelleno
     */
    public function setCantidadRelleno($cantidadRelleno)
    {
        $this->cantidadRelleno = $cantidadRelleno;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Secuencia
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    
        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }
}