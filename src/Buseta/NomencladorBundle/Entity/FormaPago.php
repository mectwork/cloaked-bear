<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormaPago
 *
 * @ORM\Table(name="n_formapago")
 * @ORM\Entity
 */
class FormaPago extends BaseNomenclador
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
     * @var \Buseta\NomencladorBundle\Entity\CajaChica
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\CajaChica", inversedBy="formaPago")
     */
    private $cajaChica;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\CajaChica $cajaChica
     */
    public function setCajaChica($cajaChica)
    {
        $this->cajaChica = $cajaChica;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\CajaChica
     */
    public function getCajaChica()
    {
        return $this->cajaChica;
    }

    public function __toString()
    {
        return $this->valor;
    }

}