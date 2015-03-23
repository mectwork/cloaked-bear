<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * GarantiaTarea.
 *
 * @ORM\Table(name="n_garantiatarea")
 * @ORM\Entity
 */
class GarantiaTarea extends BaseNomenclador
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
     * @var integer
     *
     * @ORM\Column(name="dias", type="integer")
     * @Assert\NotBlank()
     */
    protected $dias;

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
     * Get dias.
     *
     * @return int
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set dias.
     *
     * @param int $dias
     */
    public function setDias($dias)
    {
        $this->dias = $dias;
    }
}
