<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Condicion.
 *
 * @ORM\Table(name="n_condicion_producto")
 * @ORM\Entity(repositoryClass="Buseta\NomencladorBundle\Entity\CondicionRepository")
 */
class Condicion extends BaseNomenclador
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
