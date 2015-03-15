<?php

namespace HatueyERP\TercerosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HatueyERP\TercerosBundle\Form\Model\ClienteModel;

/**
 * Cliente
 *
 * @ORM\Table(name="c_cliente")
 * @ORM\Entity
 */
class Cliente
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
     * @var \HatueyERP\TercerosBundle\Entity\Tercero
     *
     * @ORM\OneToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Tercero", inversedBy="cliente")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $tercero;


    /**
     * @param ClienteModel $model
     * @return $this
     */
    public function setModelData(ClienteModel $model)
    {
        $this->tercero = $model->getTercero();

        return $this;
    }

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
     * Set tercero
     *
     * @param \HatueyERP\TercerosBundle\Entity\Tercero $tercero
     * @return Cliente
     */
    public function setTercero(\HatueyERP\TercerosBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero
     *
     * @return \HatueyERP\TercerosBundle\Entity\Tercero 
     */
    public function getTercero()
    {
        return $this->tercero;
    }
}
