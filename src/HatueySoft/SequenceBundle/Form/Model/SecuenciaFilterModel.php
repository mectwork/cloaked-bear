<?php

namespace HatueySoft\SequenceBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Secuencia Model
 *
 */
class SecuenciaFilterModel
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var string
     */
    private $prefijo;

    /**
     * @var string
     */
    private $sufijo;

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return string
     */
    public function getPrefijo()
    {
        return $this->prefijo;
    }

    /**
     * @param string $prefijo
     */
    public function setPrefijo($prefijo)
    {
        $this->prefijo = $prefijo;
    }

    /**
     * @return string
     */
    public function getSufijo()
    {
        return $this->sufijo;
    }

    /**
     * @param string $sufijo
     */
    public function setSufijo($sufijo)
    {
        $this->sufijo = $sufijo;
    }

}
