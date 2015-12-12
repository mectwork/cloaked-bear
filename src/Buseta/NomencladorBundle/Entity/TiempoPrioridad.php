<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * TiempoPrioridad
 *
 * @ORM\Table(name="n_tiempo_prioridad")
 * @ORM\Entity
 */
class TiempoPrioridad extends BaseNomenclador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    //tiene tambien el campo valor que es donde guarda el nombre ( 1600M O 2400M ETC )

    /**
     * @var integer
     * @ORM\Column(name="minutos", type="integer")
     */
    private $minutos;

    /**
     * @var string
     * @ORM\Column(name="colorentiempo", type="string", length=7)
     */
    private $colorentiempo;

    /**
     * @var string
     * @ORM\Column(name="coloratrasado", type="string", length=7)
     */
    private $coloratrasado;




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
     * Get minutos
     *
     * @return integer
     */
    public function getMinutos()
    {
        return $this->minutos;
    }

    /**
     * Set minutos.
     *
     * @param integer $minutos
     *
     * @return TiempoPrioridad
     */
    public function setMinutos($minutos)
    {
        $this->minutos = $minutos;
        return $this;
    }



    /**
     * Set colorentiempo.
     *
     * @param string $colorentiempo
     *
     * @return TiempoPrioridad
     */
    public function setColorentiempo($colorentiempo)
    {
        $this->colorentiempo = $colorentiempo;

        return $this;
    }

    /**
     * Get colorentiempo.
     * @return string
     */
    public function getColorentiempo()
    {
        return $this->colorentiempo;
    }

    /**
     * Set coloratrasado.
     * @param string $coloratrasado
     * @return TiempoPrioridad
     */
    public function setColoratrasado($coloratrasado)
    {
        $this->coloratrasado = $coloratrasado;

        return $this;
    }

    /**
     * Get coloratrasado.
     *
     * @return string
     */
    public function getColoratrasado()
    {
        return $this->coloratrasado;
    }


}
