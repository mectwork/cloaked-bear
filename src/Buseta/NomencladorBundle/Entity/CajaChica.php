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
     * @var \Buseta\NomencladorBundle\Entity\FormaPago
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\FormaPago", inversedBy="cajas_chicas")
     */
    private $forma_pago;

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
     * Set forma_pago
     *
     * @param \Buseta\NomencladorBundle\Entity\FormaPago $formaPago
     * @return CajaChica
     */
    public function setFormaPago(\Buseta\NomencladorBundle\Entity\FormaPago $formaPago = null)
    {
        $this->forma_pago = $formaPago;
    
        return $this;
    }

    /**
     * Get forma_pago
     *
     * @return \Buseta\NomencladorBundle\Entity\FormaPago 
     */
    public function getFormaPago()
    {
        return $this->forma_pago;
    }

    public function __toString()
    {
        return $this->valor;
    }
}