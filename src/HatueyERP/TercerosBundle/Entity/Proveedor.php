<?php

namespace HatueyERP\TercerosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HatueyERP\TercerosBundle\Form\Model\ProveedorModel;

/**
 * Proveedor
 *
 * @ORM\Table(name="c_proveedor")
 * @ORM\Entity
 */
class Proveedor
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
     * @ORM\OneToOne(targetEntity="HatueyERP\TercerosBundle\Entity\Tercero", inversedBy="proveedor")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $tercero;


    /**
     * @param ProveedorModel $model
     * @return $this
     */
    public function setModelData(ProveedorModel $model)
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
     * @return Proveedor
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
