<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CajaChica.
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
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\FormaPago")
     */
    private $forma_pago;

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
     * Set valor.
     *
     * @param string $valor
     *
     * @return CajaChica
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor.
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @return FormaPago
     */
    public function getFormaPago()
    {
        return $this->forma_pago;
    }

    /**
     * @param FormaPago $forma_pago
     */
    public function setFormaPago($forma_pago)
    {
        $this->forma_pago = $forma_pago;
    }

    public function __toString()
    {
        return $this->valor;
    }
}
