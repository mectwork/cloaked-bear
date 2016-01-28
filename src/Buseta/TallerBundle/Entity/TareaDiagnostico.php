<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 *
 * @ORM\Table(name="d_diagnostico_tarea")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\Repository\TareaDiagnosticoRepository")
 */
class TareaDiagnostico
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo")
     */
    private $grupo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupo;

    /**
     * @var \Buseta\TallerBundle\Entity\TareaMantenimiento
     *
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\TareaMantenimiento")
     * @Assert\NotNull
     */
    private $tareamantenimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    private $descripcion;

    /**
     * @var \Buseta\TallerBundle\Entity\Diagnostico
     *
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\Diagnostico", inversedBy="tareaDiagnostico")
     */
    private $diagnostico;


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
     * Set grupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     *
     * @return TareaDiagnostico
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
     * @return TareaDiagnostico
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
     * Set tareamantenimiento.
     *
     * @param \Buseta\TallerBundle\Entity\TareaMantenimiento $tareamantenimiento
     *
     * @return TareaDiagnostico
     */
    public function setTareaMantenimiento(\Buseta\TallerBundle\Entity\TareaMantenimiento $tareamantenimiento = null)
    {
        $this->tareamantenimiento = $tareamantenimiento;

        return $this;
    }

    /**
     * Get tareamantenimiento.
     *
     * @return \Buseta\TallerBundle\Entity\TareaMantenimiento
     */
    public function getTareaMantenimiento()
    {
        return $this->tareamantenimiento;
    }

    /**
     * Set Diagnostico.
     *
     * @param \Buseta\TallerBundle\Entity\Diagnostico $diagnostico
     *
     * @return TareaDiagnostico
     */
    public function setDiagnostico(\Buseta\TallerBundle\Entity\Diagnostico $diagnostico = null)
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get Diagnostico.
     *
     * @return \Buseta\TallerBundle\Entity\Diagnostico
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return TareaDiagnostico
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
