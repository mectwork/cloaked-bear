<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tarea.
 *
 * @ORM\Table(name="n_tarea")
 * @ORM\Entity
 */
class Tarea extends BaseNomenclador
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
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo")
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\GarantiaTarea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\GarantiaTarea")
     */
    private $garantia;

    /**
     * @var float
     *
     * @ORM\Column(name="kilometros", type="float", nullable=true)
     * @Assert\NotBlank()
     */
    private $kilometros;

    /**
     * @var string
     *
     * @ORM\Column(name="horas", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $horas;

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
     * @return Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param Grupo $grupo
     */
    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * @return Subgrupo
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
    }

    /**
     * @param Subgrupo $subgrupo
     */
    public function setSubgrupo($subgrupo)
    {
        $this->subgrupo = $subgrupo;
    }

    /**
     * @return GarantiaTarea
     */
    public function getGarantia()
    {
        return $this->garantia;
    }

    /**
     * @param GarantiaTarea $garantia
     */
    public function setGarantia($garantia)
    {
        $this->garantia = $garantia;
    }

    /**
     * @return float
     */
    public function getKilometros()
    {
        return $this->kilometros;
    }

    /**
     * @param float $kilometros
     */
    public function setKilometros($kilometros)
    {
        $this->kilometros = $kilometros;
    }

    /**
     * @return string
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * @param string $horas
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;
    }
}
