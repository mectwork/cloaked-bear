<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modelo
 *
 * @ORM\Table(name="n_modelo")
 * @ORM\Entity
 */
class Modelo extends BaseNomenclador
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
     * @var \Buseta\NomencladorBundle\Entity\Marca
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Marca")
     */
    private $marca;

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
     * @return Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param Marca $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }


    public function __toString()
    {
        return $this->valor;
    }

}