<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TareaMantenimiento.
 *
 * @ORM\Table(name="d_tarea_mantenimiento")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\TareaMantenimientoRepository")
 * @UniqueEntity(fields={"valor", "grupo", "subgrupo"}, repositoryMethod="onlyOneTarea", message="Ya se encuentra registrada una Tarea de Mantenimiento con este mismo Grupo y Subgrupo.")
 */
class TareaMantenimiento
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
     * @var \Buseta\NomencladorBundle\Entity\Tarea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Tarea")
     * @Assert\NotNull
     */
    private $valor;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Grupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo", cascade={"persist"})
     */
    private $grupo;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Subgrupo
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo", cascade={"persist"})
     */
    private $subgrupo;

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
     * @var \Buseta\NomencladorBundle\Entity\GarantiaTarea
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\GarantiaTarea")
     */
    private $garantia;

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
     * Set kilometros.
     *
     * @param float $kilometros
     *
     * @return TareaMantenimiento
     */
    public function setKilometros($kilometros)
    {
        $this->kilometros = $kilometros;

        return $this;
    }

    /**
     * Get kilometros.
     *
     * @return float
     */
    public function getKilometros()
    {
        return $this->kilometros;
    }

    /**
     * Set horas.
     *
     * @param string $horas
     *
     * @return TareaMantenimiento
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get horas.
     *
     * @return string
     */
    public function getHoras()
    {
        return $this->horas;
    }

    /**
     * Set grupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     *
     * @return TareaMantenimiento
     */
    public function setGrupo(\Buseta\NomencladorBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo.
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set subgrupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo
     *
     * @return TareaMantenimiento
     */
    public function setSubgrupo(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupo = null)
    {
        $this->subgrupo = $subgrupo;

        return $this;
    }

    /**
     * Get subgrupo.
     *
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo
     */
    public function getSubgrupo()
    {
        return $this->subgrupo;
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
     * Set valor.
     *
     * @param \Buseta\NomencladorBundle\Entity\Tarea $valor
     *
     * @return TareaMantenimiento
     */
    public function setValor(\Buseta\NomencladorBundle\Entity\Tarea $valor = null)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor.
     *
     * @return \Buseta\NomencladorBundle\Entity\Tarea
     */
    public function getValor()
    {
        return $this->valor;
    }

    public function __toString()
    {
        return $this->getValor();
    }
}
