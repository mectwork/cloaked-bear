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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\NomencladorBundle\Entity\CajaChica", mappedBy="forma_pago", cascade={"all"})
     */
    private $cajas_chicas;

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
     * @return FormaPago
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
     * Add caja_chica
     *
     * @param \Buseta\NomencladorBundle\Entity\CajaChica $caja_chica
     * @return Grupo
     */
    public function addCajaChica(\Buseta\NomencladorBundle\Entity\CajaChica $caja_chica)
    {
        $caja_chica->setGrupo($this);

        $this->caja_chica[] = $caja_chica;

        return $this;
    }

    /**
     * Remove caja_chica
     *
     * @param \Buseta\NomencladorBundle\Entity\CajaChica $caja_chica
     */
    public function removeCajaChica(\Buseta\NomencladorBundle\Entity\CajaChica $caja_chica)
    {
        $this->caja_chica->removeElement($caja_chica);
    }

    /**
     * Get caja_chica
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCajaChicas()
    {
        return $this->caja_chica;
    }


    public function __toString()
    {
        return $this->valor;
    }

}