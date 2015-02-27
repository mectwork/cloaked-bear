<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CajaChica
 *
 * @ORM\Table(name="n_cajachica")
 * @ORM\Entity
 */
class CajaChica extends BaseNomenclador
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
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255)
     */
    protected $valor;

    /**
     * @var \Buseta\NomencladorBundle\Entity\FormaPago
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\FormaPago")
     */
    private $formaPago;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->valor;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return CajaChica
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set formaPago
     *
     * @param \Buseta\NomencladorBundle\Entity\FormaPago $formaPago
     * @return CajaChica
     */
    public function setFormaPago(\Buseta\NomencladorBundle\Entity\FormaPago $formaPago = null)
    {
        $this->formaPago = $formaPago;
    
        return $this;
    }

    /**
     * Get formaPago
     *
     * @return \Buseta\NomencladorBundle\Entity\FormaPago 
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }
}