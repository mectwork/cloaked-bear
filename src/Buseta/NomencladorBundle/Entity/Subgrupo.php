<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subgrupo.
 *
 * @ORM\Table(name="n_subgrupo")
 * @ORM\Entity
 */
class Subgrupo extends BaseNomenclador
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
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo", inversedBy="subgrupos")
     */
    private $grupo;

    /**
     * Set grupo.
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupo
     *
     * @return Modelo
     */
    public function setMarca(\Buseta\NomencladorBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
