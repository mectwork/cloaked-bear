<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MantenimientoPorcientoCumplido.
 *
 * @ORM\Table(name="n_mantenimiento_porciento_cumplido")
 * @ORM\Entity
 */
class MantenimientoPorcientoCumplido extends BaseNomenclador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var float
     *
     * @ORM\Column(name="porciento", type="float")
     */
    private $porciento;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7)
     */
    private $color;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set porciento.
     *
     * @param float $porciento
     *
     * @return MantenimientoPorcientoCumplido
     */
    public function setPorciento($porciento)
    {
        $this->porciento = $porciento;

        return $this;
    }

    /**
     * Get porciento.
     *
     * @return float
     */
    public function getPorciento()
    {
        return $this->porciento;
    }

    /**
     * Set color.
     *
     * @param string $color
     *
     * @return MantenimientoPorcientoCumplido
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    public function __toString()
    {
        return $this->color;
    }
}
